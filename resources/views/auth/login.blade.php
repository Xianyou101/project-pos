<x-filament-panels::page.simple>
    <x-slot name="title">
        {{ __('Sistem Warehouse RTSP 31') }}
    </x-slot>

    <div x-data="{ tab: 'login' }" class="space-y-6 w-full max-w-md mx-auto">
        {{-- Tab switch --}}
        <div class="flex justify-center gap-4">
            <button
                x-on:click="tab = 'login'"
                :class="tab === 'login' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            >
                Login
            </button>
            <button
                x-on:click="tab = 'register'"
                :class="tab === 'register' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300'"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            >
                Daftar
            </button>
        </div>

        {{-- Login Form --}}
        <div x-show="tab === 'login'" x-cloak class="space-y-4">
            <form method="POST" action="{{ route('filament.admin.auth.login') }}" class="space-y-4">
                @csrf

                <x-filament::input
                    name="email"
                    type="email"
                    label="Alamat Email"
                    required
                    autocomplete="email"
                />

                <x-filament::input
                    name="password"
                    type="password"
                    label="Kata Sandi"
                    required
                    autocomplete="current-password"
                />

                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="form-checkbox">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Ingat saya</span>
                </label>

                <x-filament::button type="submit" class="w-full">
                    Masuk
                </x-filament::button>
            </form>
        </div>

        {{-- Register Form --}}
        <div x-show="tab === 'register'" x-cloak class="space-y-4">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <x-filament::input
                    name="name"
                    type="text"
                    label="Nama Lengkap"
                    required
                    autocomplete="name"
                />

                <x-filament::input
                    name="email"
                    type="email"
                    label="Alamat Email"
                    required
                    autocomplete="email"
                />

                <x-filament::input
                    name="password"
                    type="password"
                    label="Kata Sandi"
                    required
                    autocomplete="new-password"
                />

                <x-filament::input
                    name="password_confirmation"
                    type="password"
                    label="Konfirmasi Kata Sandi"
                    required
                    autocomplete="new-password"
                />

                <x-filament::button type="submit" class="w-full">
                    Daftar
                </x-filament::button>
            </form>
        </div>
    </div>
</x-filament-panels::page.simple>
