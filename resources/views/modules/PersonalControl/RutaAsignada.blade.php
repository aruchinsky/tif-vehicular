<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tus Tareas de Control Asignadas') }}
        </h2>
        @include('partials._tabs_navigation')
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            @if ($personalControls->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                    <p class="text-xl text-red-500 dark:text-red-400">
                        No se encontró ninguna tarea de control asignada a tu usuario.
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Por favor, contacta a tu administrador si crees que esto es un error.
                    </p>
                </div>
            @else
                
                {{-- Mensaje de Bienvenida --}}
                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-6">
                    ¡Bienvenido, {{ $personalControls->first()->nombre_apellido }}! 
                </h3>

                {{-- Contenedor de Asignaciones (Grid para múltiples tarjetas) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    @foreach ($personalControls as $asignacion)
                        
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border-t-4 {{ $loop->first ? 'border-indigo-600' : 'border-gray-400 dark:border-gray-700' }} transition hover:shadow-2xl">
                            
                            {{-- Título y Etiqueta de la Asignación --}}
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-700 dark:text-gray-200">
                                    Asignación #{{ $loop->iteration }}
                                </h4>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full uppercase 
                                    {{ $loop->first ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100' : 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $loop->first ? 'Última / Principal' : 'Previa' }}
                                </span>
                            </div>

                            {{-- Bloque principal de Ruta --}}
                            <div class="bg-yellow-50 dark:bg-gray-700 p-4 rounded-lg mb-4 shadow-inner">
                                <p class="text-sm font-semibold uppercase text-yellow-700 dark:text-yellow-300">Ruta Asignada</p>
                                <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">
                                    {{ $asignacion->ruta ?? 'RUTA NO DEFINIDA' }}
                                </p>
                            </div>

                            {{-- Detalles de la Asignación --}}
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="p-2 border-b dark:border-gray-700">
                                    <p class="font-semibold text-gray-500 dark:text-gray-400">Fecha de Control:</p>
                                    <p class="text-gray-900 dark:text-gray-100">
                                        {{ $asignacion->fecha_control ? \Carbon\Carbon::parse($asignacion->fecha_control)->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="p-2 border-b dark:border-gray-700">
                                    <p class="font-semibold text-gray-500 dark:text-gray-400">Lugar:</p>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $asignacion->lugar ?? 'N/A' }}</p>
                                </div>
                                <div class="p-2">
                                    <p class="font-semibold text-gray-500 dark:text-gray-400">Horario:</p>
                                    <p class="text-gray-900 dark:text-gray-100">
                                        {{ $asignacion->hora_inicio ?? 'N/A' }} - {{ $asignacion->hora_fin ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="p-2">
                                    <p class="font-semibold text-gray-500 dark:text-gray-400">Rol en Control:</p>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $asignacion->rol_en_control ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
                
                <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-300 italic">
                    Si tienes múltiples asignaciones, la más reciente aparecerá primero.
                </p>

            @endif
            
        </div>
    </div>
</x-app-layout>