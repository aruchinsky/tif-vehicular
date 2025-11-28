@php
    $user = auth()->user();
    $isAdmin = $user ? $user->isAdmin() : false;
    
    // Usamos $isAdmin para simplificar, si no es Admin, es "Rol 2" (o rol de operación)
    $isOperator = !$isAdmin; 

    // Definición de las rutas y etiquetas
    $navItems = [
        [
            'label' => 'Mi Ruta', // Nuevo elemento para Rol 2
            'route' => 'personalcontrol.ruta.asignada', // Usamos la nueva ruta
            // Verifica si la ruta actual es la de "Mi Ruta"
            'active' => request()->routeIs('personalcontrol.ruta.asignada'), 
            // Visible SOLO si es Operador (Rol 2)
            'show' => $isOperator, 
        ],
        [
            'label' => 'Personal Control',
            'route' => 'personalcontrol.index',
            'active' => request()->routeIs('personalcontrol.index'), // Ajuste: * ya no es necesaria
            // Visible SOLO si es Admin (Rol 1)
            'show' => $isAdmin, 
        ],
        [
            'label' => 'Productividad',
            'route' => 'productividades.index',
            'active' => request()->routeIs('productividades.*'),
            // Visible SOLO si es Admin (Rol 1)
            'show' => $isAdmin, 
        ],
        [
            'label' => 'Conductores',
            'route' => 'conductores.index',
            'active' => request()->routeIs('conductores.*'),
            // Visible SOLO si es Operador (Rol 2)
            'show' => $isOperator, 
        ],
        [
            'label' => 'Acompañantes',
            'route' => 'acompaniante.index', 
            'active' => request()->routeIs('acompaniante.*'),
            // Visible SOLO si es Operador (Rol 2)
            'show' => $isOperator,
        ],
        [
            'label' => 'Vehículos',
            'route' => 'vehiculo.index',
            'active' => request()->routeIs('vehiculo.*'),
            // Visible SOLO si es Operador (Rol 2)
            'show' => $isOperator,
        ],
        [
            'label' => 'Novedades',
            'route' => 'novedades.index',
            'active' => request()->routeIs('novedades.*'),
            // Visible SOLO si es Operador (Rol 2)
            'show' => $isOperator,
        ],
        
    ];
@endphp

{{-- Menú de Navegación con Estilo de Tabs --}}
<nav class="flex space-x-1 border-b border-gray-200 dark:border-gray-700">
    @foreach($navItems as $item)
        @if($item['show'])
            <a href="{{ route($item['route']) }}" 
               class="px-4 py-2 text-sm font-medium transition-all duration-150 ease-in-out
                      {{-- Estilos cuando la pestaña está activa (página actual) --}}
                      {{ $item['active'] 
                          ? 'border-b-2 border-indigo-600 dark:border-indigo-400 dark:text-indigo-400' 
                          : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-b-2 hover:border-gray-300 dark:hover:border-gray-600'
                      }}">
                {{ $item['label'] }}
            </a>
        @endif
    @endforeach
</nav>