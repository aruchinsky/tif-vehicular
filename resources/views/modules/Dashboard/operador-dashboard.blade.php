{{-- resources/views/modules/Dashboard/operador-dashboard.blade.php --}}

<x-app-layout>

    {{-- ========================================================= --}}
    {{-- ======================= HEADER ========================== --}}
    {{-- ========================================================= --}}
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
                Panel del Operador
            </h2>
            <p class="text-sm mt-1" style="color: var(--muted-foreground);">
                Operativos policiales asignados a tu jornada
            </p>
        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto px-4 space-y-10">


        {{-- ========================================================= --}}
        {{-- ======= CASO: EL USUARIO NO ESTÁ VINCULADO A PERSONAL ==== --}}
        {{-- ========================================================= --}}
        @if (!$personal)

            <div class="p-10 rounded-xl shadow text-center border"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-xl font-semibold mb-2">No estás asignado como Operador</h3>

                <p class="text-sm" style="color: var(--muted-foreground);">
                    Consultá con tu Administrador o Jefe de Unidad.
                </p>

            </div>


        @else

        {{-- ========================================================= --}}
        {{-- ==================== MÉTRICAS DEL DÍA ==================== --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

            {{-- Vehículos cargados --}}
            <div class="p-4 shadow rounded-xl border-l-4"
                style="background: var(--card); border-color:#3b82f6;">
                <p class="text-xs" style="color: var(--muted-foreground);">Vehículos cargados</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $metricas['vehiculosHoy'] }}</h2>
            </div>

            {{-- Conductores --}}
            <div class="p-4 shadow rounded-xl border-l-4"
                style="background: var(--card); border-color:#16a34a;">
                <p class="text-xs" style="color: var(--muted-foreground);">Conductores</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $metricas['conductoresHoy'] }}</h2>
            </div>

            {{-- Acompañantes --}}
            <div class="p-4 shadow rounded-xl border-l-4"
                style="background: var(--card); border-color:#f59e0b;">
                <p class="text-xs" style="color: var(--muted-foreground);">Acompañantes</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $metricas['acompanantesHoy'] }}</h2>
            </div>

            {{-- Novedades --}}
            <div class="p-4 shadow rounded-xl border-l-4"
                style="background: var(--card); border-color:#dc2626;">
                <p class="text-xs" style="color: var(--muted-foreground);">Novedades cargadas</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $metricas['novedadesHoy'] }}</h2>
            </div>

            {{-- Próximo operativo --}}
            <div class="p-4 shadow rounded-xl border-l-4"
                style="background: var(--card); border-color:#0ea5e9;">
                <p class="text-xs" style="color: var(--muted-foreground);">Próximo operativo</p>
                <h2 class="text-lg font-semibold mt-1">
                    {{ $metricas['tiempoRestante'] ?? '—' }}
                </h2>
            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- ================== PRÓXIMO OPERATIVO ===================== --}}
        {{-- ========================================================= --}}
        @if ($proximo)

            @php
                $inicio = \Carbon\Carbon::parse($proximo->hora_inicio)->format('H:i');
                $fin    = \Carbon\Carbon::parse($proximo->hora_fin)->format('H:i');
                $fecha  = \Carbon\Carbon::parse($proximo->fecha)->format('d/m/Y');
            @endphp

            <div class="rounded-xl p-6 shadow border relative overflow-hidden"
                 style="background: var(--primary); color: var(--primary-foreground);">

                <div class="absolute right-6 top-6 opacity-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 5l9-3 9 3v6c0 5-3.5 9.74-9 11-5.5-1.26-9-6-9-11V5z"/>
                    </svg>
                </div>

                <h3 class="text-xl font-semibold mb-2">Próximo Operativo Asignado</h3>

                <p class="text-lg font-semibold">{{ $proximo->lugar }}</p>

                <p class="text-sm opacity-90">
                    {{ $fecha }} — {{ $inicio }} a {{ $fin }}
                </p>

                <div class="mt-4">
                    <a href="{{ route('control.operador.show', $proximo->id) }}"
                       class="px-5 py-2 rounded-lg font-bold shadow bg-white text-black hover:bg-gray-200 transition">
                        Ingresar al Operativo →
                    </a>
                </div>
            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- =================== LISTA DE OPERATIVOS ================== --}}
        {{-- ========================================================= --}}
        <h3 class="text-xl font-semibold mt-6" style="color: var(--foreground);">
            Todos tus operativos asignados
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            @forelse ($controles as $control)

                @php
                    $actividad = $control->vehiculosControlados->count();
                    $estadoLabel = $actividad > 0 ? 'Con actividad' : 'Sin actividad';
                    $estadoColor = $actividad > 0
                        ? 'bg-green-600 text-white'
                        : 'bg-gray-500 text-white';

                    $inicio = \Carbon\Carbon::parse($control->hora_inicio)->format('H:i');
                    $fin    = \Carbon\Carbon::parse($control->hora_fin)->format('H:i');
                    $fecha  = \Carbon\Carbon::parse($control->fecha)->format('d/m/Y');
                @endphp

                <div class="shadow rounded-xl border transition hover:shadow-lg"
                     style="background: var(--card); border-color: var(--border);">

                    {{-- HEADER --}}
                    <div class="px-6 py-4 border-b"
                         style="background: var(--muted); border-color: var(--border);">
                        <h4 class="font-semibold text-lg">{{ $fecha }}</h4>
                    </div>

                    {{-- BODY --}}
                    <div class="px-6 py-4 space-y-2 text-sm">
                        <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
                        <p><strong>Ruta:</strong> {{ $control->ruta ?? '—' }}</p>
                        <p><strong>Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>
                        <p><strong>Horario:</strong> {{ $inicio }} — {{ $fin }}</p>

                        <div class="mt-2">
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $estadoColor }}">
                                {{ $estadoLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="px-6 py-4 border-t text-right"
                         style="border-color: var(--border);">
                        <a href="{{ route('control.operador.show', $control->id) }}"
                           class="px-4 py-2 rounded-lg font-semibold shadow bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition">
                            Abrir Operativo →
                        </a>
                    </div>
                </div>

            @empty

                <div class="p-8 rounded-xl shadow text-center"
                     style="background: var(--card); color: var(--foreground);">
                    <p class="text-lg font-semibold">No tenés operativos asignados.</p>
                </div>

            @endforelse

        </div>

        @endif {{-- cierre de $personal --}}

    </div>

</x-app-layout>
