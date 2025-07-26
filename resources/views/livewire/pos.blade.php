<div 
    x-data="scanBarcodeComponent()"
    class="grid grid-cols-1 dark:bg-gray-900 md:grid-cols-3 gap-4"
>

    {{-- Katalog Produk --}}
    <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <div class="mb-4 flex gap-2 items-start">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari produk..."
                class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

            {{-- Tombol Scan Barcode --}}
            <button 
                @click="confirmScan = true"
                class="px-4 py-2 rounded text-white font-bold shadow-md transition
                       bg-green-500 hover:bg-green-600
                       dark:bg-green-400 dark:hover:bg-green-500"
            >
                Scan Barcode
            </button>
        </div>

        {{-- Konfirmasi sebelum scan --}}
        <template x-if="confirmScan">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-sm">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 text-center">
                        Buka Kamera?
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                        Aplikasi akan menggunakan kamera untuk memindai QR/barcode produk.
                    </p>
                    <div class="flex justify-center gap-4">
                        <button 
                            class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                            @click="confirmScan = false"
                        >Batal</button>
                        <button 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold"
                            @click="startScanner()"
                        >Lanjut</button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Modal Scanner --}}
        <div 
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
                <h2 class="text-lg font-semibold text-center mb-4 text-gray-800 dark:text-gray-100">
                    QR Code Scanner
                </h2>
                <div id="reader" class="w-full h-[300px] rounded-md overflow-hidden border-4 border-yellow-400 relative">
                    <div class="absolute inset-0 border-4 border-yellow-400 pointer-events-none z-10 rounded-md"></div>
                </div>
                <button 
                    @click="stopScanner()" 
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-600 dark:text-gray-300 text-xl font-bold">
                    ✕
                </button>
            </div>
        </div>

        {{-- Daftar Produk --}}
        <div class="flex-grow">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($products as $item)
                    <div wire:click="addToOrder({{ $item->id }})"
                        class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow cursor-pointer transition hover:scale-105">
                        <img src="{{ $item->image_url }}"
                            alt="Product Image"
                            class="w-full h-16 object-cover rounded-lg mb-2">
                        <h3 class="text-sm font-semibold">{{ $item->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Stok: {{ $item->stock }}</p>
                    </div>
                @endforeach
            </div>
            <div class="py-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- Keranjang dan Checkout --}}
    <div class="md:col-span-1 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        @if(count($order_items) > 0)
            <div class="py-4">
                <h3 class="text-lg font-semibold text-center">
                    Total: Rp {{ number_format($this->calculateTotal(), 0, ',', '.') }}
                </h3>
            </div>
        @endif

        {{-- Daftar Item --}}
        @foreach($order_items as $item)
            <div class="mb-4">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <img src="{{ $item['image_url'] }}" alt="Product Image"
                            class="w-10 h-10 object-cover rounded-lg mr-2">
                        <div class="px-2">
                            <h3 class="text-sm font-semibold">{{ $item['name'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-xs">
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button wire:click="decreaseQuantity({{ $item['product_id'] }})"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">-</button>
                        <span class="px-3 text-sm">{{ $item['quantity'] }}</span>
                        <button wire:click="increaseQuantity({{ $item['product_id'] }})"
                            class="bg-green-600 text-white px-2 py-1 rounded">+</button>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Form Checkout --}}
        <form wire:submit.prevent="checkout">
            {{ $this->form }}

            <button 
                type="submit" 
                class="w-full bg-red-500 mt-3 text-white py-2 rounded hover:bg-red-600">
                Checkout
            </button>
        </form>
    </div>
</div>

{{-- Script & Komponen QR --}}
<script src="https://unpkg.com/html5-qrcode" defer></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

<script>
    function scanBarcodeComponent() {
        return {
            confirmScan: false,
            open: false,
            scanner: null,
            startScanner() {
                this.confirmScan = false;
                this.open = true;
                this.$nextTick(() => {
                    this.scanner = new Html5Qrcode('reader');
                    this.scanner.start(
                        { facingMode: 'environment' },
                        {
                            fps: 15,
                            qrbox: { width: 300, height: 300 }
                        },
                        (decodedText) => {
                            Livewire.emit('scanResult', decodedText);
                            alert('✅ Scan berhasil: ' + decodedText);
                            this.scanner.stop();
                            this.open = false;
                        },
                        (error) => {
                            console.warn("❌ Scan gagal:", error);
                        }
                    ).catch(err => {
                        alert('❌ Tidak dapat mengakses kamera: ' + err);
                        this.open = false;
                    });
                });
            },
            stopScanner() {
                if (this.scanner) {
                    this.scanner.stop();
                }
                this.open = false;
            }
        }
    }
</script>
