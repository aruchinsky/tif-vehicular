@php
    $user = auth()->user();
    // Usamos el método isAdmin() que creamos en el modelo User
    $isAdmin = $user ? $user->isAdmin() : false;
    
    // Determinar la ruta inicial basada en el rol
    if ($isAdmin) {
        // Rol 1 (Admin) va al CRUD de Personal Control
        $initialRoute = route('personalcontrol.index');
    } else {
        // Rol 2 (Personal Control/Operador) va a la pantalla de Ruta Asignada
        $initialRoute = route('personalcontrol.ruta.asignada');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Redirigiendo...') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-100">
                    Bienvenido al Panel de Control
                </h3>

                {{-- Muestra un enlace si la redirección falla o tarda --}}
                <p class="text-gray-500 dark:text-gray-400 mb-4">
                    Serás redirigido a tu panel principal.
                </p>

                <a href="{{ $initialRoute }}"
                   class="inline-block px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                   Ir a mi Panel
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script de Redirección Automática (la forma más limpia en Blade) --}}
<script>
    window.location.href = "{{ $initialRoute }}";
</script>