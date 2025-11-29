@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control Vehicular') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <x-banner />

    <div class="min-h-screen flex flex-col">

        {{-- NAVIGATION MODERNO --}}
        @include('layouts.navigation')


        {{-- Encabezado dinámico --}}
        @isset($header)
            <header class="bg-gradient-to-r from-blue-600 to-indigo-600 shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-6 lg:px-8">
                    <h2 class="font-semibold text-2xl text-white leading-tight">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        {{-- CONTENIDO --}}
        <main class="flex-1 py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl p-6">
                    {{ $slot }}
                </div>

            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-100 dark:bg-gray-800 text-center text-sm text-gray-600 dark:text-gray-300 py-4 mt-auto">
            © {{ date('Y') }} Control Vehicular — Todos los derechos reservados.
        </footer>

    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts

</body>
</html>
