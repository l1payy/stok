<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Aplikasi Monitoring Persediaan Stok Obat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-pagebg">
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Sidebar (Desktop) -->
            <aside class="hidden md:flex flex-col w-[240px] bg-primary text-white min-h-screen fixed left-0 top-0 bottom-0 z-20">
                <div class="p-6 flex flex-col items-center">
                    <img src="{{ asset('storage/logo/logo.png') }}" class="w-20 h-20 mb-3" alt="Logo">
                    <h1 class="text-xl font-bold leading-tight">Karang Rejo</h1>
                    <p class="text-xs text-blue-300 opacity-70">Monitoring Stok</p>
                </div>

                <nav class="flex-1 mt-6 px-4 space-y-2">
                    <x-nav-link-custom :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                        Dashboard
                    </x-nav-link-custom>
                    
                    <x-nav-link-custom :href="route('obat.index')" :active="request()->routeIs('obat.*')" icon="medicine">
                        Inventaris Obat
                    </x-nav-link-custom>

                    <x-nav-link-custom :href="route('transaksi-masuk.index')" :active="request()->routeIs('transaksi-masuk.*')" icon="plus">
                        Stok Masuk
                    </x-nav-link-custom>

                    <x-nav-link-custom :href="route('transaksi-keluar.index')" :active="request()->routeIs('transaksi-keluar.*')" icon="minus">
                        Stok Keluar
                    </x-nav-link-custom>

                    <x-nav-link-custom :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" icon="report">
                        Laporan
                    </x-nav-link-custom>
                </nav>

                <div class="p-4 mt-auto">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-300 hover:text-red-100 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 md:ml-[240px] flex flex-col min-h-screen">
                <!-- Topbar -->
                <header class="bg-pagebg h-16 flex items-center justify-between px-6 sticky top-0 z-10">
                    <h2 class="text-2xl font-bold text-primary">
                        @yield('title', 'Dashboard')
                    </h2>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-6 flex-1 pb-24 md:pb-6">
                    @yield('content')
                </main>
            </div>

            <!-- Bottom Navigation (Mobile) -->
            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-3 px-2 z-20">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-accent' : 'text-gray-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-[10px] mt-1">Dashboard</span>
                </a>
                <a href="{{ route('obat.index') }}" class="flex flex-col items-center {{ request()->routeIs('obat.*') ? 'text-accent' : 'text-gray-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span class="text-[10px] mt-1">Obat</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="flex flex-col items-center {{ request()->routeIs('laporan.*') ? 'text-accent' : 'text-gray-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-[10px] mt-1">Laporan</span>
                </a>
            </nav>
        </div>
    </body>
</html>
