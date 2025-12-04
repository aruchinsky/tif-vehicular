<style>
    /* Scroll más estético en el panel */
    .offcanvas-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .offcanvas-scroll::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }
</style>

{{-- NAV SUPERIOR --}}
<nav x-data="{ open:false }"
     class="shadow border-b"
     style="background-color:var(--card); color:var(--foreground);">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO --}}
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="text-xl font-bold"
                   style="color: var(--primary);">
                    Control Vehicular
                </a>
            </div>




            {{-- ========================================================
                 🔔 + USER + SWITCH — DESKTOP
            ======================================================== --}}
            <div class="hidden md:flex items-center relative space-x-4">
                {{-- ===================================================== --}}
                {{-- MENÚ COMPLETO PARA SUPERUSUARIO (DESKTOP) --}}
                {{-- ===================================================== --}}
                @hasrole('SUPERUSUARIO')
                <div class="flex items-center gap-4">

                    <a href="{{ route('dashboard.super') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Dashboard
                    </a>

                    <a href="{{ route('personalcontrol.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Personal
                    </a>

                    <a href="{{ route('controles.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Controles
                    </a>

                    <a href="{{ route('vehiculo.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Vehículos
                    </a>

                    <a href="{{ route('conductores.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Conductores
                    </a>

                    <a href="{{ route('acompaniante.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Acompañantes
                    </a>

                    <a href="{{ route('novedades.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Novedades
                    </a>

                    <a href="{{ route('productividad.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Productividad
                    </a>

                    <a href="{{ route('cargos-policiales.index') }}"
                    class="text-sm font-semibold hover:underline"
                    style="color:var(--foreground);">
                        Cargos
                    </a>

                </div>
                @endhasrole


                {{-- SWITCH DE TEMA (DESKTOP) --}}
                <button x-data
                        @click="
                            const html = document.documentElement;
                            const isDark = html.classList.contains('dark');
                            html.classList.toggle('dark', !isDark);
                            localStorage.setItem('theme', isDark ? 'light' : 'dark');
                        "
                        class="p-2 rounded-full hover:bg-[var(--muted)] transition">

                    <svg x-show="!document.documentElement.classList.contains('dark')"
                         class="w-6 h-6 text-[var(--foreground)]" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 5a7 7 0 100 14 7 7 0 000-14z"/>
                    </svg>

                    <svg x-show="document.documentElement.classList.contains('dark')"
                         class="w-6 h-6 text-[var(--foreground)]" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                    </svg>
                </button>




                {{-- USER MENU DESKTOP --}}
                <div x-data="{ uopen:false }" class="relative">

                    <button @click="uopen = !uopen"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-[var(--muted)] transition">

                        <svg class="w-6 h-6 text-[var(--foreground)]" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 14a4 4 0 01-8 0m4-10a4 4 0 110 8 4 4 0 010-8z" />
                        </svg>

                        <span class="text-sm font-semibold text-[var(--foreground)]">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    {{-- DROPDOWN --}}
                    <div x-show="uopen" x-transition x-cloak
                        @click.away="uopen=false"
                        class="absolute right-0 mt-2 w-48 rounded-xl shadow-xl border z-50"
                        style="background-color:var(--card); border-color:var(--border);">

                        <a href="{{ route('profile.show') }}"
                           class="block px-4 py-3 text-sm hover:bg-[var(--muted)] rounded-t-xl transition">
                            Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm hover:bg-[var(--muted)] rounded-b-xl transition">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>

                </div>




                {{-- CAMPANA DESKTOP --}}
                @hasanyrole('ADMINISTRADOR|SUPERUSUARIO')
                <div x-data="campanaDesktop()" x-init="init()" x-cloak class="relative">

                    <button @click="open = !open"
                        class="relative p-2 rounded-full hover:bg-[var(--muted)] transition">

                        <svg class="w-6 h-6 text-[var(--foreground)]" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.4-1.4A2 2 0 0118 14V10a6 6 0 10-12 0v4c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/>
                        </svg>

                        <template x-if="contador > 0">
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                                <span x-text="contador"></span>
                            </span>
                        </template>
                    </button>


                    {{-- LISTA NOTIFICACIONES --}}
                    <div x-show="open" x-transition x-cloak
                        @click.away="open=false"
                        class="absolute right-0 mt-2 w-80 rounded-xl shadow-xl border z-50"
                        style="background-color:var(--card); border-color:var(--border);">

                        <div class="p-3 border-b" style="border-color:var(--border)">
                            <h3 class="font-bold text-sm">Notificaciones recientes</h3>
                        </div>

                        <div class="max-h-80 overflow-y-auto">

                            <template x-if="notificaciones.length === 0">
                                <p class="p-4 text-sm text-center text-[var(--muted-foreground)]">
                                    No hay notificaciones
                                </p>
                            </template>

                            <template x-for="item in notificaciones" :key="'dnotif-'+item.uid">
                                <div class="p-4 border-b hover:bg-[var(--muted)] cursor-pointer transition"
                                     style="border-color:var(--border);">

                                    <p class="text-red-600 font-semibold text-sm">🚨 <span x-text="item.tipo"></span></p>
                                    <p class="text-xs text-[var(--muted-foreground)]">
                                        Vehículo: <span x-text="item.dominio"></span>
                                    </p>
                                    <p class="text-xs text-[var(--muted-foreground)]">
                                        Hora: <span x-text="item.hora"></span>
                                    </p>
                                </div>
                            </template>

                        </div>

                        <a href="{{ route('novedades.index') }}"
                           class="block text-center p-3 text-sm font-semibold hover:bg-[var(--muted)] rounded-b-xl"
                           style="color:var(--primary);">
                            Ver todas →
                        </a>

                    </div>

                </div>
                @endhasanyrole

            </div>





            {{-- ========================================================
                 🔔 + USER + HAMBURGER — MOBILE
            ======================================================== --}}
            <div class="flex items-center gap-4 md:hidden">


{{-- ========================================================= --}}
{{-- MENU MOBILE DESLIZANTE (OFFCANVAS) --}}
{{-- ========================================================= --}}
<div 
    x-cloak
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
    class="fixed inset-0 z-[9999] md:hidden"
>

    {{-- Fondo oscuro --}}
    <div @click="open=false" class="absolute inset-0 bg-black/40"></div>

    {{-- Panel deslizante --}}
    <div class="absolute right-0 top-0 h-full w-72 shadow-xl p-6 space-y-4 overflow-y-auto offcanvas-scroll"
        style="background-color:var(--card); border-left:1px solid var(--border);">



        {{-- Cerrar --}}
        <div class="flex justify-end">
            <button @click="open=false" class="p-2 rounded hover:bg-[var(--muted)]">
                ✕
            </button>
        </div>

        {{-- SOLO SUPERUSUARIO --}}
        @hasrole('SUPERUSUARIO')
        <nav class="space-y-3">

            <a href="{{ route('dashboard.super') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🏠 Dashboard</a>

            <a href="{{ route('personalcontrol.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">👮 Personal</a>

            <a href="{{ route('controles.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🚓 Controles</a>

            <a href="{{ route('vehiculo.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🚗 Vehículos</a>

            <a href="{{ route('conductores.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">👤 Conductores</a>

            <a href="{{ route('acompaniante.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🧍 Acompañantes</a>

            <a href="{{ route('novedades.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🚨 Novedades</a>

            <a href="{{ route('productividad.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">📊 Productividad</a>

            <a href="{{ route('cargos-policiales.index') }}"
               class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
               style="color:var(--foreground);">🎖️ Cargos</a>

        </nav>
        @endhasrole

        <hr style="border-color:var(--border)">

        {{-- SWITCH --}}
        <button x-data
                @click="
                    const html = document.documentElement;
                    const dark = html.classList.contains('dark');
                    html.classList.toggle('dark', !dark);
                    localStorage.setItem('theme', dark ? 'light' : 'dark');
                "
                class="w-full flex items-center gap-2 px-2 py-2 rounded hover:bg-[var(--muted)] transition">
            🌗 Cambiar tema
        </button>

        {{-- PERFIL --}}
        <a href="{{ route('profile.show') }}"
           class="block px-2 py-2 rounded hover:bg-[var(--muted)]"
           style="color:var(--foreground);">👤 Perfil</a>

        {{-- CERRAR SESIÓN --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left px-2 py-2 rounded hover:bg-[var(--muted)]"
                style="color:var(--foreground);">
                🚪 Cerrar sesión
            </button>
        </form>

    </div>

</div>






                {{-- CAMPANA MOBILE --}}
                @hasanyrole('ADMINISTRADOR|SUPERUSUARIO')
                <div x-data="campanaMobile()" x-init="init()" x-cloak class="relative">

                    <button @click="openMobile = !openMobile"
                        class="relative p-2 rounded-full hover:bg-[var(--muted)]">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.4-1-1.4A2 2 0 0118 14V10a6 6 0 10-12 0v4c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/>
                        </svg>

                        <template x-if="contador > 0">
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                                <span x-text="contador"></span>
                            </span>
                        </template>

                    </button>


                    {{-- LISTA MOBILE --}}
                    <div x-show="openMobile" x-transition x-cloak
                        class="absolute right-0 mt-2 w-64 rounded-lg shadow-lg border z-[9999]"
                        style="background: var(--card); border-color: var(--border);">

                        <div class="p-3 border-b" style="border-color:var(--border);">
                            <h3 class="font-bold text-sm">Notificaciones recientes</h3>
                        </div>

                        <div class="max-h-72 overflow-y-auto">

                            <template x-if="notificaciones.length === 0">
                                <p class="p-4 text-sm text-center text-[var(--muted-foreground)]">
                                    No hay notificaciones
                                </p>
                            </template>

                            <template x-for="item in notificaciones" :key="'mnotif-'+item.uid">
                                <div class="p-4 border-b hover:bg-[var(--muted)]"
                                     style="border-color: var(--border);">

                                    <p class="text-red-600 font-semibold text-sm">🚨 <span x-text="item.tipo"></span></p>
                                    <p class="text-xs text-[var(--muted-foreground)]">
                                        Vehículo: <span x-text="item.dominio"></span>
                                    </p>
                                    <p class="text-xs text-[var(--muted-foreground)]">
                                        Hora: <span x-text="item.hora"></span>
                                    </p>

                                </div>
                            </template>
                        </div>

                        <a href="{{ route('novedades.index') }}"
                           class="block p-3 text-center text-sm font-semibold hover:bg-[var(--muted)] rounded-b-lg"
                           style="color:var(--primary);">
                            Ver todas →
                        </a>

                    </div>
                </div>
                @endhasanyrole




                {{-- HAMBURGER --}}
                <button @click="open = !open"
                        class="p-2 rounded-md hover:bg-[var(--muted)] focus:outline-none transition">

                    <svg class="h-6 w-6 text-[var(--foreground)]" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>

            </div>

        </div>
    </div>

</nav>




{{-- ===================================================== --}}
{{-- JS: CAMPANA DESKTOP / MOBILE USANDO EL STORE GLOBAL --}}
{{-- ===================================================== --}}
<script>
function campanaDesktop() {
    return {
        open:false,
        contador:0,
        notificaciones:[],

        init() {
            window.NotificacionesStore.subscribe((lista) => {
                this.notificaciones = lista.slice(0, 20);
                this.contador = lista.length;
            });
        }
    }
}

function campanaMobile() {
    return {
        openMobile:false,
        contador:0,
        notificaciones:[],

        init() {
            window.NotificacionesStore.subscribe((lista) => {
                this.notificaciones = lista.slice(0, 20);
                this.contador = lista.length;
            });
        }
    }
}
</script>
