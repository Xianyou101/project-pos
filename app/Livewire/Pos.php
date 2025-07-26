<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaymentMethod;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class Pos extends Component implements HasForms
{
    use InteractsWithForms;

    public $search = '';
    public $name_customer = '';
    public $gender = '';
    public $payment_method_id = null;
    public $payment_methods;
    public $order_items = [];
    public $total_price = 0;
    public $isScannerOpen = false;

    protected $listeners = [
        'scanResult' => 'handleScanResult',
        'toggle-scanner' => 'toggleScanner',
    ];

    public function mount()
    {
        $this->payment_methods = PaymentMethod::all();

        if (session()->has('orderItems')) {
            $this->order_items = session('orderItems');
        }

        $this->calculateTotal();

        $this->form->fill([
            'name_customer' => $this->name_customer,
            'gender' => $this->gender,
            'payment_method_id' => $this->payment_method_id,
            'total_price' => $this->total_price,
        ]);
    }

    public function render()
    {
        return view('livewire.pos', [
            'products' => Product::where('stock', '>', 0)
                ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                ->paginate(12),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Form Checkout')->schema([
                TextInput::make('name_customer')
                    ->required()
                    ->label('Nama Customer'),
                Select::make('gender')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->required()
                    ->label('Jenis Kelamin'),
                TextInput::make('total_price')
                    ->readOnly()
                    ->numeric()
                    ->label('Total Harga')
                    ->default(fn () => $this->total_price),
                Select::make('payment_method_id')
                    ->required()
                    ->label('Metode Pembayaran')
                    ->options(fn () => $this->payment_methods->pluck('name', 'id')),
            ]),
        ]);
    }

    public function addToOrder($productId)
    {
        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) {
            Notification::make()
                ->title($product ? 'Stok habis' : 'Produk tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        foreach ($this->order_items as $key => $item) {
            if ($item['product_id'] == $productId) {
                $this->order_items[$key]['quantity']++;
                $this->updateSession();
                Notification::make()->title('Jumlah produk ditambahkan')->success()->send();
                return;
            }
        }

        $this->order_items[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image_url' => $product->image_url,
            'quantity' => 1,
        ];

        $this->updateSession();
        Notification::make()->title('Produk ditambahkan ke keranjang')->success()->send();
    }

    public function increaseQuantity($product_id)
    {
        $product = Product::find($product_id);
        if (!$product) return;

        foreach ($this->order_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($item['quantity'] + 1 <= $product->stock) {
                    $this->order_items[$key]['quantity']++;
                } else {
                    Notification::make()
                        ->title('Stok tidak mencukupi')
                        ->danger()
                        ->send();
                }
                break;
            }
        }

        $this->updateSession();
    }

    public function decreaseQuantity($product_id)
    {
        foreach ($this->order_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($item['quantity'] > 1) {
                    $this->order_items[$key]['quantity']--;
                } else {
                    unset($this->order_items[$key]);
                    $this->order_items = array_values($this->order_items);
                }
                break;
            }
        }

        $this->updateSession();
    }

    public function calculateTotal()
    {
        $this->total_price = collect($this->order_items)
            ->sum(fn ($item) => $item['price'] * $item['quantity']);

        return $this->total_price;
    }

    public function checkout()
    {
        $this->validate([
            'name_customer' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $order = Order::create([
            'name' => $this->name_customer,
            'gender' => $this->gender,
            'total_price' => $this->calculateTotal(),
            'payment_method_id' => $this->payment_method_id,
        ]);

        foreach ($this->order_items as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);

            // Kurangi stok
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        $this->order_items = [];
        session()->forget('orderItems');

        Notification::make()->title('Transaksi berhasil')->success()->send();
        return redirect()->to('/admin/orders');
    }

    public function handleScanResult($decodedText)
    {
        $product = Product::where('barcode', $decodedText)->first();

        if ($product) {
            $this->addToOrder($product->id);

            Log::info('✅ Barcode berhasil dipindai', [
                'barcode' => $decodedText,
                'product_id' => $product->id,
                'product_name' => $product->name,
            ]);

            Notification::make()
                ->title('Produk ditemukan: ' . $product->name)
                ->success()
                ->send();
        } else {
            Log::warning('❌ Barcode tidak ditemukan', [
                'barcode' => $decodedText,
            ]);

            Notification::make()
                ->title('Produk tidak ditemukan: ' . $decodedText)
                ->danger()
                ->send();
        }
    }

    public function toggleScanner()
    {
        $this->isScannerOpen = !$this->isScannerOpen;
    }

    private function updateSession()
    {
        session()->put('orderItems', $this->order_items);
        $this->calculateTotal();
    }
}
