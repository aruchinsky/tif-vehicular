@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control Vehicular') }}</title>

    {{-- APLICAR TEMA ANTES DE CARGAR --}}
    <script>
        (() => {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <x-banner />

    {{-- NAV SUPERIOR (YA NO HAY HEADER ABAJO) --}}
    @include('layouts.navigation')

    {{-- CONTENIDO PRINCIPAL MODERNO --}}
    <main class="py-10" style="background-color: var(--background); transition: background 0.3s;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- CARD CONTENEDORA --}}
            <div class="shadow-sm sm:rounded-2xl p-8"
                style="background-color: var(--card); color: var(--card-foreground); transition: background 0.3s, color 0.3s;">

                {{-- TÍTULO --}}
                @isset($header)
                    <h1 class="text-3xl font-bold mb-8" 
                        style="color: var(--foreground); transition: color 0.3s;">
                        {{ $header }}
                    </h1>
                @endisset

                {{ $slot }}

            </div>

        </div>
    </main>


    {{-- FOOTER --}}
    <footer class="bg-gray-100 dark:bg-gray-800 text-center text-sm text-gray-600 dark:text-gray-300 py-4">
        © {{ date('Y') }} Control Vehicular — Todos los derechos reservados.
    </footer>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>
</html>
