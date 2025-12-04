@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control Vehicular') }}</title>

    {{-- TEMA --}}
    <script>
        (() => {
            const t = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.toggle('dark', t === 'dark');
        })();
    </script>

    {{-- ROLES --}}
    <script>
        window.appRoles = @json(auth()->check() ? auth()->user()->getRoleNames() : []);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>[x-cloak]{display:none!important}</style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <x-banner />
    @include('layouts.navigation')

    <main class="py-10" style="background-color: var(--background);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-sm sm:rounded-2xl p-8"
                 style="background-color: var(--card); color: var(--card-foreground);">

                @isset($header)
                    <h1 class="text-3xl font-bold mb-8" style="color:var(--foreground);">
                        {{ $header }}
                    </h1>
                @endisset

                {{ $slot }}

            </div>
        </div>
    </main>

    <footer class="bg-gray-100 dark:bg-gray-800 text-center text-sm text-gray-600 dark:text-gray-300 py-4">
        © {{ date('Y') }} Control Vehicular — Todos los derechos reservados.
    </footer>

    @stack('modals')
    @stack('scripts')
    @livewireScripts


    <!-- ========================================================= -->
    <!-- 🧠 STORE GLOBAL UNIFICADO -->
    <!-- ========================================================= -->
    <script>
        // Esto hace de store global para notificaciones
        // Cada componente Alpine puede suscribirse para recibir actualizaciones
        // y también el backend puede emitir eventos que se propagarán aquí
        window.NotificacionesStore = {
            // lista de callbacks suscritos
            // y la data actual
            // (notificaciones más recientes primero)
            // cada notificación es un objeto con:
            // { tipo, dominio, conductor, hora }
            listeners: [],
            data: [],

            // agregar una nueva notificación
            // al inicio de la lista
            // y notificar a los suscriptores
            // n: { tipo, dominio, conductor, hora }
            push(n) {
                // insert al inicio
                // esto hace que las notificaciones más recientes
                // estén al principio
                this.data.unshift(n);

                // anunciar a cada componente Alpine
                // esto hace que se llame el callback
                // de cada suscriptor con la data actualizada
                this.listeners.forEach(cb => cb(this.data));
            },

            // suscribirse a cambios
            // callback: función que recibe la lista actualizada
            // porque se suscribe, se llama inmediatamente
            // con la data actual 
            subscribe(callback) {
                this.listeners.push(callback);
                callback(this.data); // inicializar
            }
        };
    </script>


    <!-- ========================================================= -->
    <!-- 🔵 ALERTAS AZULES -->
    <!-- ========================================================= -->
    <div x-data="alertasNovedad()" x-init="init()" x-cloak wire:ignore
        class="fixed top-4 right-4 z-[99999] space-y-3">

        <template x-for="item in alertas" :key="'alerta-'+item.uid">
            <div x-transition.opacity
                class="px-5 py-4 bg-blue-600 text-white rounded-lg shadow-lg border border-blue-300">
                <strong>Nueva novedad 🚨</strong>
                <div>Tipo: <span x-text="item.tipo"></span></div>
                <div>Vehículo: <span x-text="item.dominio"></span></div>
                <div>Conductor: <span x-text="item.conductor"></span></div>
                <div class="text-xs opacity-70" x-text="item.hora"></div>
            </div>
        </template>
    </div>

    <script>
        function alertasNovedad() {
            return {
                alertas: [],

                init() {
                    window.NotificacionesStore.subscribe((lista) => {
                        this.alertas = lista.slice(0, 3);
                        setTimeout(() => this.alertas.shift(), 5000);
                    });
                }
            }
        }
    </script>


</body>
</html>

