<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Monitoring Stok Obat') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-pagebg text-gray-900 antialiased flex flex-col items-center justify-center min-h-screen p-6">
        <div class="max-w-4xl w-full flex flex-col items-center text-center">
            <header class="w-full mb-12 flex justify-end">
                @if (Route::has('login'))
                    <nav class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition duration-150">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition duration-150">Login</a>
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="flex flex-col items-center bg-white p-12 rounded-3xl shadow-xl border border-gray-100 max-w-2xl w-full">
                <img src="{{ asset('storage/logo/logo.png') }}" class="w-48 h-48 mb-8 object-contain" alt="Logo">
                <h1 class="text-4xl font-extrabold text-primary mb-4 leading-tight">Monitoring Persediaan Stok Obat</h1>
                <p class="text-gray-500 text-lg mb-10">Puskesmas Karang Rejo</p>
                
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/20 transition duration-150">
                        Masuk ke Dashboard
                    </a>
                </div>
            </main>

            <footer class="mt-16 text-gray-400 text-sm">
                &copy; {{ date('Y') }} UPT Puskesmas Karang Rejo
            </footer>
        </div>
    </body>
</html>
