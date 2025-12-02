<div 
    :class="expanded ? 'w-64' : 'w-20'"
    class="hidden md:flex flex-col bg-gray-900 text-gray-100 h-screen 
           transition-all duration-300 overflow-hidden"
>

    {{-- LOGO Y BOTÓN --}}
    <div class="flex items-center justify-between p-4 border-b border-gray-700">

        <span x-show="expanded" x-transition class="text-xl font-bold text-blue-400">
            Control Vehicular
        </span>

        <button 
            @click="expanded = !expanded"
            class="p-2 rounded hover:bg-gray-800"
        >
            <x-icon name="menu" class="w-6 h-6"/>
        </button>
    </div>

    {{-- MENÚ --}}
    <nav class="flex-1 py-4 space-y-1">

        {{-- ADMINISTRADOR y SUPERUSUARIO --}}
        @hasanyrole('ADMINISTRADOR|SUPERUSUARIO')

            @foreach([
                ['route'=>'dashboard', 'label'=>'Inicio', 'icon'=>'home'],
                ['route'=>'controles.index', 'label'=>'Controles Policiales', 'icon'=>'badge-check'],
                ['route'=>'personalcontrol.index', 'label'=>'Personal', 'icon'=>'users'],
                ['route'=>'vehiculo.index', 'label'=>'Vehículos', 'icon'=>'car'],
                ['route'=>'conductores.index', 'label'=>'Conductores', 'icon'=>'id-card'],
                ['route'=>'acompaniante.index', 'label'=>'Acompañantes', 'icon'=>'users-round'],
                ['route'=>'novedades.index', 'label'=>'Novedades', 'icon'=>'alert-triangle'],
                ['route'=>'productividad.index', 'label'=>'Productividad', 'icon'=>'bar-chart'],
            ] as $item)

                <a href="{{ route($item['route']) }}"
                    class="relative group flex items-center gap-3 px-4 py-3 text-sm rounded-lg 
                           hover:bg-gray-800 transition 
                           {{ request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}"
                >

                    {{-- Icono --}}
                    <x-icon name="{{ $item['icon'] }}" class="w-6 h-6"/>

                    {{-- Texto --}}
                    <span x-show="expanded" x-transition class="whitespace-nowrap">
                        {{ $item['label'] }}
                    </span>

                    {{-- Tooltip --}}
                    <span 
                        x-show="!expanded"
                        class="absolute left-full ml-3 py-1 px-2 bg-gray-800 text-white rounded shadow 
                               opacity-0 group-hover:opacity-100 transition whitespace-nowrap"
                    >
                        {{ $item['label'] }}
                    </span>

                </a>

            @endforeach

        @endhasanyrole

        {{-- OPERADOR --}}
        @hasrole('OPERADOR')

            @foreach([
                ['route'=>'dashboard', 'label'=>'Inicio', 'icon'=>'home'],
                ['route'=>'control.ruta', 'label'=>'Mi Ruta', 'icon'=>'map'],
                ['route'=>'control.conductores.create', 'label'=>'Registrar Conductor', 'icon'=>'id-card'],
                ['route'=>'control.acompaniante.create', 'label'=>'Registrar Acompañante', 'icon'=>'users'],
                ['route'=>'control.vehiculo.create', 'label'=>'Registrar Vehículo', 'icon'=>'car'],
            ] as $item)

                <a href="{{ route($item['route']) }}"
                    class="relative group flex items-center gap-3 px-4 py-3 text-sm rounded-lg 
                           hover:bg-gray-800 transition 
                           {{ request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}"
                >

                    <x-icon name="{{ $item['icon'] }}" class="w-6 h-6"/>

                    <span x-show="expanded" x-transition class="whitespace-nowrap">
                        {{ $item['label'] }}
                    </span>

                    <span 
                        x-show="!expanded"
                        class="absolute left-full ml-3 py-1 px-2 bg-gray-800 text-white rounded shadow 
                               opacity-0 group-hover:opacity-100 transition whitespace-nowrap"
                    >
                        {{ $item['label'] }}
                    </span>

                </a>

            @endforeach

        @endhasrole

    </nav>

    {{-- LOGOUT --}}
    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center gap-3 hover:bg-gray-800 rounded px-4 py-3 w-full transition">
                <x-icon name="log-out" class="w-6 h-6"/>
                
                <span x-show="expanded" x-transition>Cerrar sesión</span>

                <span 
                    x-show="!expanded"
                    class="absolute left-full ml-3 py-1 px-2 bg-gray-800 text-white rounded shadow 
                           opacity-0 group-hover:opacity-100 transition whitespace-nowrap"
                >
                    Cerrar sesión
                </span>
            </button>
        </form>
    </div>

</div>
