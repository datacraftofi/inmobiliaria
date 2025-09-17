<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Tema: inicialización -->
        <script id="theme-init">
            (function () {
                try {
                    const stored = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    const useDark = stored ? stored === 'dark' : prefersDark;
                    const root = document.documentElement;
                    if (useDark) root.classList.add('dark'); else root.classList.remove('dark');
                } catch (e) {}
            })();
        </script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-500 ease-in-out">

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow text-gray-900 dark:text-gray-100 transition-colors duration-500 ease-in-out">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                
            @endisset

            <!-- Page Content -->
            <main class="text-gray-900 dark:text-gray-100 transition-colors duration-500 ease-in-out">
                {{-- 🔹 Aquí la corrección para soportar slot o section --}}
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>

        <script>
        (function () {
            function setTheme(dark) {
                const root = document.documentElement;
                if (dark) root.classList.add('dark'); else root.classList.remove('dark');
                localStorage.setItem('theme', dark ? 'dark' : 'light');
            }

            const toggle = document.getElementById('theme-toggle');
            const toggleMobile = document.getElementById('theme-toggle-mobile');

            function init() {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const useDark = stored ? stored === 'dark' : prefersDark;
                setTheme(useDark);
            }

            function toggleTheme() {
                setTheme(!document.documentElement.classList.contains('dark'));
            }

            if (toggle) toggle.addEventListener('click', toggleTheme);
            if (toggleMobile) toggleMobile.addEventListener('click', toggleTheme);

            init();
        })();
        </script>
    </body>
</html>
