<div 
    x-data="{ 
        open: @entangle('isScannerOpen'), 
        scanner: null 
    }" 
    x-show="open" 
    x-cloak
    x-init="
        $watch('open', value => {
            if (value) {
                $nextTick(() => {
                    scanner = new Html5Qrcode('reader');
                    scanner.start(
                        { facingMode: 'environment' },
                        {
                            fps: 15,
                            qrbox: { width: 300, height: 300 },
                        },
                        (decodedText) => {
                            Livewire.emit('scanResult', decodedText);
                            scanner.stop().then(() => {
                                scanner.clear();
                                open = false;
                            }).catch(() => {});
                        },
                        (error) => {
                            console.warn('Scan error:', error);
                        }
                    ).catch(err => {
                        console.error('Start failed:', err);
                        open = false;
                    });
                });
            } else if (scanner) {
                scanner.stop()
                    .then(() => scanner.clear())
                    .catch(() => {});
            }
        });
    "
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <h2 class="text-lg font-semibold text-center mb-4 text-gray-800 dark:text-gray-100">
            QR Code Scanner
        </h2>

        <div 
            id="reader" 
            class="w-full h-[300px] rounded-md overflow-hidden border border-gray-300 dark:border-gray-600">
        </div>

        <button 
            @click="open = false; if (scanner) scanner.stop().then(() => scanner.clear()).catch(() => {});" 
            class="absolute top-2 right-2 text-gray-500 hover:text-red-600 dark:text-gray-300 text-xl font-bold"
        >
            ✕
        </button>
    </div>
</div>

{{-- Load QR Code Scanner library --}}
<script src="https://unpkg.com/html5-qrcode" defer></script>
