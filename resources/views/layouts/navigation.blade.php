{{-- NAVIGATION UNIFICADO + TEMAS DINÁMICOS --}}
<nav x-data="{ open: false, userOpen: false }"
     class="shadow border-b"
     style="background-color: var(--card); color: var(--foreground); border-color: var(--border);">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- 🔵 LOGO + MENÚ DESKTOP --}}
            <div class="flex items-center space-x-8">

                {{-- LOGO --}}
                <a href="{{ route('dashboard') }}"
                   class="text-xl font-bold"
                   style="color: var(--primary);">
                    Control Vehicular
                </a>

                {{-- MENÚ DESKTOP --}}
                <div class="hidden md:flex space-x-2">

                    {{-- ADMIN --}}
                    @hasrole('ADMINISTRADOR')
                        @foreach([
                            ['route' => 'dashboard', 'label' => 'Inicio', 'pat' => 'dashboard'],
                            ['route' => 'personalcontrol.index', 'label' => 'Personal Control', 'pat' => 'personalcontrol.*'],
                            ['route' => 'vehiculo.index', 'label' => 'Vehículos', 'pat' => 'vehiculo.*'],
                            ['route' => 'conductores.index', 'label' => 'Conductores', 'pat' => 'conductores.*'],
                            ['route' => 'acompaniante.index', 'label' => 'Acompañantes', 'pat' => 'acompaniante.*'],
                            ['route' => 'novedades.index', 'label' => 'Novedades', 'pat' => 'novedades.*'],
                            ['route' => 'productividad.index', 'label' => 'Productividad', 'pat' => 'productividad.*'],
                        ] as $item)
                            <a href="{{ route($item['route']) }}"
                                class="px-3 py-2 rounded-md text-sm font-medium transition"
                                style="
                                    background-color: {{ request()->routeIs($item['pat']) ? 'var(--primary)' : 'transparent' }};
                                    color: {{ request()->routeIs($item['pat']) ? 'var(--primary-foreground)' : 'var(--foreground)' }};
                                "
                                onmouseover="this.style.backgroundColor='var(--muted)'"
                                onmouseout="this.style.backgroundColor='{{ request()->routeIs($item['pat']) ? 'var(--primary)' : 'transparent' }}'">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    @endhasrole

                    {{-- CONTROL --}}
                    @hasrole('CONTROL')
                        @foreach([
                            ['route' => 'dashboard', 'label' => 'Inicio', 'pat' => 'dashboard'],
                            ['route' => 'control.ruta', 'label' => 'Mi Ruta', 'pat' => 'control.ruta'],
                            ['route' => 'control.conductores.create', 'label' => 'Registrar Conductor', 'pat' => 'control.conductores.create'],
                            ['route' => 'control.acompaniante.create', 'label' => 'Registrar Acompañante', 'pat' => 'control.acompaniante.create'],
                            ['route' => 'control.vehiculo.create', 'label' => 'Registrar Vehículo', 'pat' => 'control.vehiculo.create'],
                        ] as $item)
                            <a href="{{ route($item['route']) }}"
                                class="px-3 py-2 rounded-md text-sm font-medium transition"
                                style="
                                    background-color: {{ request()->routeIs($item['pat']) ? 'var(--primary)' : 'transparent' }};
                                    color: {{ request()->routeIs($item['pat']) ? 'var(--primary-foreground)' : 'var(--foreground)' }};
                                "
                                onmouseover="this.style.backgroundColor='var(--muted)'"
                                onmouseout="this.style.backgroundColor='{{ request()->routeIs($item['pat']) ? 'var(--primary)' : 'transparent' }}'">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    @endhasrole

                </div>
            </div>

            {{-- 🔵 SWITCH TEMA + USER --}}
            <div class="hidden md:flex items-center relative space-x-4">

                {{-- 🌗 SWITCH TEMA --}}
                <div x-data="{
                        theme: localStorage.getItem('theme') || 'light',
                        toggle() {
                            this.theme = this.theme === 'dark' ? 'light' : 'dark';
                            localStorage.setItem('theme', this.theme);
                            document.documentElement.classList.toggle('dark', this.theme === 'dark');
                        }
                    }"
                    x-init="document.documentElement.classList.toggle('dark', theme === 'dark')">

                    <button @click="toggle()"
                        class="p-2 rounded-full border transition"
                        style="border-color: var(--border); background-color: var(--muted); color: var(--foreground);">

                        {{-- 🌙 Luna --}}
                        <svg x-show="theme === 'dark'" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 1010 9.79z"/>
                        </svg>

                        {{-- ☀ Sol (fix real) --}}
                        <svg x-show="theme === 'light'" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4.75a.75.75 0 01.75-.75h.5a.75.75 0 010 1.5h-.5A.75.75 0 0112 4.75zM12 18.25a.75.75 0 01.75.75h.5a.75.75 0 010 1.5h-.5a.75.75 0 01-.75-.75v-.5zM4.75 12a.75.75 0 01-.75-.75v-.5a.75.75 0 011.5 0v.5A.75.75 0 014.75 12zm14.5 0a.75.75 0 01-.75-.75v-.5a.75.75 0 011.5 0v.5a.75.75 0 01-.75.75zM6.47 6.47a.75.75 0 011.06 0l.35.35a.75.75 0 01-1.06 1.06l-.35-.35a.75.75 0 010-1.06zm10.7 10.7a.75.75 0 011.06 0l.35.35a.75.75 0 01-1.06 1.06l-.35-.35a.75.75 0 010-1.06zM6.47 17.53a.75.75 0 011.06 0l.35.35a.75.75 0 11-1.06 1.06l-.35-.35a.75.75 0 010-1.06zm10.7-10.7a.75.75 0 011.06 0l.35.35a.75.75 0 11-1.06 1.06l-.35-.35a.75.75 0 010-1.06zM12 7a5 5 0 110 10a5 5 0 010-10z"/>
                        </svg>
                    </button>

                </div>

                {{-- USER BUTTON --}}
                <button @click="userOpen = !userOpen"
                        class="flex items-center space-x-2 hover:opacity-80 transition"
                        style="color: var(--foreground);">

                    <span>{{ Auth::user()->name }}</span>

                    <svg class="h-4 w-4" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a1 1 0 011.4-.02L10 10.45l3.37-3.26a1 1 0 011.38 1.44l-4 3.87a1 1 0 01-1.38 0l-4-3.87a1 1 0 01-.14-1.42z"/>
                </button>

                {{-- DROPDOWN USER --}}
                <div x-show="userOpen"
                     x-cloak
                     @click.away="userOpen = false"
                     x-transition
                     class="absolute right-0 mt-12 w-48 rounded shadow-lg"
                     style="background: var(--card); border: 1px solid var(--border);">

                    <a href="{{ route('profile.show') }}"
                       class="block px-4 py-2 text-sm hover:bg-[var(--muted)]"
                       style="color: var(--foreground);">
                        Mi Perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full text-left px-4 py-2 text-sm hover:bg-[var(--muted)]"
                                style="color: var(--destructive);">
                            Cerrar sesión
                        </button>
                    </form>
                </div>

            </div>

            {{-- 🔵 BOTÓN MOBILE --}}
            <button class="md:hidden"
                @click="open = true"
                style="color: var(--foreground);">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- 🔵 MOBILE OVERLAY --}}
    <div x-show="open"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-60 z-40"
         @click="open = false"
         x-transition.opacity></div>

    {{-- 🔵 MENU LATERAL MOBILE --}}
    <aside x-show="open"
           x-cloak
           @click.away="open = false"
           class="fixed top-0 left-0 w-64 h-full shadow-xl z-50 p-6"
           x-transition
           style="background-color: var(--card); color: var(--foreground);">

        <h3 class="text-xl font-bold mb-6" style="color: var(--primary);">Menú</h3>

        <div class="space-y-3">

            @hasrole('ADMINISTRADOR')
                @foreach([
                    ['route' => 'dashboard', 'label' => 'Inicio'],
                    ['route' => 'personalcontrol.index', 'label' => 'Personal Control'],
                    ['route' => 'vehiculo.index', 'label' => 'Vehículos'],
                    ['route' => 'conductores.index', 'label' => 'Conductores'],
                    ['route' => 'acompaniante.index', 'label' => 'Acompañantes'],
                    ['route' => 'novedades.index', 'label' => 'Novedades'],
                    ['route' => 'productividad.index', 'label' => 'Productividad'],
                ] as $item)
                    <a class="block px-3 py-2 rounded hover:bg-[var(--muted)]"
                       href="{{ route($item['route']) }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            @endhasrole

            @hasrole('CONTROL')
                @foreach([
                    ['route' => 'dashboard', 'label' => 'Inicio'],
                    ['route' => 'control.ruta', 'label' => 'Mi Ruta'],
                    ['route' => 'control.conductores.create', 'label' => 'Registrar Conductor'],
                    ['route' => 'control.acompaniante.create', 'label' => 'Registrar Acompañante'],
                    ['route' => 'control.vehiculo.create', 'label' => 'Registrar Vehículo'],
                ] as $item)
                    <a class="block px-3 py-2 rounded hover:bg-[var(--muted)]"
                       href="{{ route($item['route']) }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            @endhasrole

        </div>

        <hr class="my-6" style="border-color: var(--border);">

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block w-full text-left px-3 py-2 rounded hover:bg-[var(--muted)]"
                    style="color: var(--destructive);">
                Cerrar sesión
            </button>
        </form>

    </aside>

</nav>
