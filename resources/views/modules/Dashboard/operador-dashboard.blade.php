<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Ícono Policial --}}
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-8 h-8 text-blue-600 dark:text-blue-400" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                    d="M3 5l9-3 9 3v6c0 5-3.5 9.74-9 11-5.5-1.26-9-6-9-11V5z"/>
            </svg>

            <h2 class="text-3xl font-extrabold" style="color: var(--foreground);">
                Panel del Operador
            </h2>
        </div>

        <p class="text-sm mt-1" style="color: var(--muted-foreground)">
            Controles policiales asignados a tu turno
        </p>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-10">

        {{-- SI NO TIENE OPERATIVOS --}}
        @if (!$personal)
            <div class="p-10 rounded-2xl shadow text-center border border-blue-300"
                 style="background: linear-gradient(135deg, #e0f2fe, #f8fafc);">

                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-16 h-16 mx-auto text-blue-600 mb-4" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <h3 class="text-2xl font-bold mb-2">No tenés ningún operativo asignado</h3>

                <p class="text-sm text-gray-600">
                    Esperá indicaciones de tu Jefe de Unidad.
                </p>
            </div>

        @else

            {{-- SALUDO PRINCIPAL --}}
            <div class="rounded-xl p-6 shadow border border-blue-500/30"
                 style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color:white;">

                <h3 class="text-3xl font-extrabold flex items-center gap-2">
                    {{ $personal->nombre_apellido }}
                </h3>

                <p class="text-blue-100 mt-2">
                    Estos son los operativos donde fuiste designado como <strong>OPERADOR</strong>.
                </p>
            </div>

            {{-- LISTADO MODERNO DE CONTROLES --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                @forelse ($controles as $control)
                    @php
                        $actividad = $control->vehiculosControlados->count();
                        $activo = $actividad > 0;

                        $estadoLabel = $activo ? 'Con actividad' : 'Sin actividad';
                        $estadoColor = $activo ? 'bg-green-600 text-white' : 'bg-gray-500 text-white';

                        $inicio = \Carbon\Carbon::parse($control->hora_inicio)->format('H:i');
                        $fin    = \Carbon\Carbon::parse($control->hora_fin)->format('H:i');
                    @endphp

                    <div class="shadow-xl rounded-2xl overflow-hidden border border-blue-200 dark:border-blue-900 transition hover:shadow-2xl"
                         style="background-color: var(--card); color: var(--card-foreground);">

                        {{-- HEADER CON FECHA --}}
                        <div class="px-6 py-4 border-b"
                             style="background: var(--primary); color: var(--primary-foreground);">
                            <h4 class="text-xl font-bold flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($control->fecha)->format('d/m/Y') }}
                            </h4>
                        </div>

                        {{-- CUERPO --}}
                        <div class="px-6 py-5 space-y-2 text-sm">

                            <p><strong class="font-semibold">Lugar:</strong> {{ $control->lugar }}</p>
                            <p><strong class="font-semibold">Ruta:</strong> {{ $control->ruta ?? '—' }}</p>
                            <p><strong class="font-semibold">Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>
                            <p><strong class="font-semibold">Horario:</strong> {{ $inicio }} – {{ $fin }}</p>

                            {{-- ESTADO --}}
                            <div class="mt-2">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $estadoColor }}">
                                    {{ $estadoLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="px-6 py-4 text-right border-t"
                             style="border-color: var(--border);">

                            <a href="{{ route('control.operador.show', $control->id) }}"
                               class="px-5 py-2 rounded-lg font-semibold shadow-lg transition
                                      bg-blue-600 text-white hover:bg-blue-700">
                                Abrir Operativo →
                            </a>

                        </div>
                    </div>

                @empty

                    <div class="p-8 rounded-xl shadow text-center"
                         style="background-color: var(--card); color: var(--card-foreground);">
                        <p class="text-lg font-semibold">Aún no tenés operativos asignados.</p>
                    </div>

                @endforelse

            </div>

        @endif

    </div>





</x-app-layout>
