<!-- resources/views/layouts/app.blade.php -->
@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased text-white bg-transparent">
    <x-banner />

    <div class="min-h-screen flex flex-col">
        <!-- Barra de navegación -->
        @livewire('navigation-menu')

        <!-- Encabezado dinámico -->
        @isset($header)
            <header class="bg-gradient-to-r from-blue-600 to-indigo-600 shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-6 lg:px-8">
                    <h2 class="font-semibold text-2xl text-white leading-tight">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        <!-- Contenido principal -->
        <main class="flex-1 py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl p-6 text-white">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <footer class="bg-gray-100 dark:bg-gray-800 text-center text-sm text-white py-4 mt-auto">
            <p>© {{ date('Y') }} {{ config('app.name', 'Laravel') }} — Todos los derechos reservados.</p>
        </footer>
    </div>

    @stack('modals')
    @stack('scripts') 

    @vite(['resources/js/app.js'])

<script>
document.addEventListener('novedad-alerta', function(event) {

    const data = event.detail;

    const div = document.createElement('div');
    div.className = "fixed top-4 right-4 bg-red-600 text-white px-4 py-3 rounded shadow-lg z-50";
    div.innerHTML = `
        <strong>⚠ Nueva novedad</strong><br>
        Vehículo: ${data.vehiculo}<br>
        ID: ${data.id}
    `;

    document.body.appendChild(div);

    setTimeout(() => div.remove(), 6000);
});
</script>
    
    @livewireScripts
</body>
</html>
