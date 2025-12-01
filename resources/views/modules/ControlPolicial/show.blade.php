<x-app-layout>
    <x-slot name="header">
        Control Policial — {{ $control->fecha }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4">

        {{-- 🔵 HEADER PRINCIPAL DEL CONTROL --}}
        <div class="card p-6 mb-8 shadow-lg rounded-xl">
            <h2 class="text-2xl font-bold mb-1">
                Operativo en {{ $control->lugar }}
            </h2>

            <p class="text-sm" style="color: var(--muted-foreground)">
                Administrado por:
                <strong>{{ $control->administrador->name ?? '—' }}</strong><br>

                Ruta: <strong>{{ $control->ruta ?? '—' }}</strong><br>
                Móvil asignado: <strong>{{ $control->movil_asignado ?? '—' }}</strong>
            </p>
        </div>

        {{-- 🔵 TABS CON ALPINE --}}
        <div x-data="{ tab: 'info' }">

            {{-- NAV PILLS --}}
            <div class="border-b border-[var(--border)] mb-6">
                <nav class="flex flex-wrap gap-3">

                    @foreach ([
                        'info' => 'Información',
                        'personal' => 'Personal',
                        'vehiculos' => 'Vehículos',
                        'civiles' => 'Civiles',
                        'novedades' => 'Novedades',
                        'productividad' => 'Productividad'
                    ] as $key => $label)

                        <button @click="tab='{{ $key }}'"
                            :class="tab=='{{ $key }}'
                                ? 'bg-[var(--primary)] text-[var(--primary-foreground)] shadow'
                                : 'hover:bg-[var(--muted)]'"
                            class="px-4 py-2 rounded-full text-sm font-semibold transition">
                            {{ $label }}
                        </button>

                    @endforeach

                </nav>
            </div>

            {{-- 🔵 TAB: INFORMACIÓN --}}
            <div x-show="tab=='info'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Información General</h3>

                <div class="grid grid-cols-2 gap-4">
                    <p><strong>Fecha:</strong> {{ $control->fecha }}</p>
                    <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
                    <p><strong>Ruta:</strong> {{ $control->ruta ?? '—' }}</p>
                    <p><strong>Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>
                    <p><strong>Inicio:</strong> {{ $control->hora_inicio }}</p>
                    <p><strong>Fin:</strong> {{ $control->hora_fin }}</p>
                </div>
            </div>

            {{-- 🔵 TAB: PERSONAL --}}
            <div x-show="tab=='personal'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Personal Asignado al Control</h3>

                @forelse ($control->personalAsignado as $asig)
                    <div class="border-b py-4" style="border-color: var(--border)">
                        <p class="font-semibold text-lg">
                            {{ $asig->personal->nombre_apellido }}
                        </p>

                        <p class="text-sm" style="color: var(--muted-foreground)">
                            Cargo: <strong>{{ $asig->personal->cargo->nombre ?? '—' }}</strong><br>
                            Usuario del sistema:
                            <strong>{{ $asig->personal->usuario->name ?? 'No asignado' }}</strong><br>
                            Legajo: <strong>{{ $asig->personal->legajo }}</strong><br>
                            Jerarquía: <strong>{{ $asig->personal->jerarquia ?? '—' }}</strong>
                        </p>
                    </div>
                @empty
                    <p class="text-sm" style="color: var(--muted-foreground)">Sin personal asignado.</p>
                @endforelse
            </div>

            {{-- 🔵 TAB: VEHÍCULOS --}}
            <div x-show="tab=='vehiculos'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Vehículos Requisados</h3>

                @forelse ($control->vehiculosControlados as $v)
                    <div class="border-b py-4" style="border-color: var(--border)">
                        <p class="font-semibold">
                            {{ $v->marca_modelo }} – {{ $v->dominio }}
                        </p>
                        <p class="text-sm">
                            Conductor: <strong>{{ $v->conductor->nombre_apellido }}</strong>
                        </p>
                    </div>
                @empty
                    <p class="text-sm" style="color: var(--muted-foreground)">
                        No se registraron vehículos.
                    </p>
                @endforelse
            </div>

            {{-- 🔵 TAB: CIVILES --}}
            <div x-show="tab=='civiles'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Civiles Registrados</h3>

                @forelse ($control->vehiculosControlados as $v)
                    <div class="border-b py-4" style="border-color: var(--border)">
                        <p class="font-semibold mb-1">
                            Conductor: {{ $v->conductor->nombre_apellido }}
                        </p>

                        @forelse ($v->conductor->acompaniante as $a)
                            <p class="text-sm">Acompañante: {{ $a->nombre_apellido }}</p>
                        @empty
                            <p class="text-sm" style="color: var(--muted-foreground)">Sin acompañantes.</p>
                        @endforelse
                    </div>
                @empty
                    <p class="text-sm" style="color: var(--muted-foreground)">Sin registros civiles.</p>
                @endforelse
            </div>

            {{-- 🔵 TAB: NOVEDADES --}}
            <div x-show="tab=='novedades'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Novedades del Operativo</h3>

                @php $hayNovedades = false; @endphp

                @foreach ($control->vehiculosControlados as $v)
                    @foreach ($v->novedades as $n)
                        @php $hayNovedades = true; @endphp
                        <div class="border-b py-4" style="border-color: var(--border)">
                            <p class="font-semibold">{{ $n->tipo_novedad }} ({{ $n->aplica }})</p>
                            <p class="text-sm">{{ $n->observaciones }}</p>
                        </div>
                    @endforeach
                @endforeach

                @unless($hayNovedades)
                    <p class="text-sm" style="color: var(--muted-foreground)">
                        No se registraron novedades.
                    </p>
                @endunless
            </div>

            {{-- 🔵 TAB: PRODUCTIVIDAD --}}
            <div x-show="tab=='productividad'" x-transition class="card p-6 rounded-xl shadow">
                <h3 class="text-xl font-bold mb-4">Productividad del Control</h3>

                <p class="text-sm" style="color: var(--muted-foreground)">
                    Próxima etapa del proyecto: estadísticas por operador.
                </p>
            </div>

        </div>
    </div>

</x-app-layout>
