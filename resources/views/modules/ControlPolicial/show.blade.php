<x-app-layout>
    <x-slot name="header">
        Control Policial — {{ $control->fecha }}
    </x-slot>

    <div class="space-y-10">

        {{-- ========================================================= --}}
        {{-- 🔵 BOTONES SUPERIORES --}}
        {{-- ========================================================= --}}
        <div class="flex items-center gap-3 mb-6">

            <a href="{{ url()->previous() }}"
            class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                    bg-[var(--primary)] text-[var(--primary-foreground)]
                    hover:opacity-90 transition">
                ← Volver
            </a>


            {{-- Editar --}}
            <a href="{{ route('controles.edit', $control) }}"
               class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                      bg-[var(--secondary)] text-white
                      hover:opacity-90 transition">
                Editar Control
            </a>

            {{-- ========================================================= --}}
            {{-- 🔴 ELIMINAR — SOLO SI NO TIENE NOVEDADES --}}
            {{-- ========================================================= --}}
            @php
                $bloqueado = $control->vehiculosControlados->filter(
                    fn($v) => $v->novedades->count() > 0
                )->count() > 0;
            @endphp

            @if($bloqueado)
                {{-- BOTÓN DESHABILITADO --}}
                <button disabled
                    class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                           bg-gray-500 text-white opacity-50 cursor-not-allowed">
                    No se puede eliminar (hay novedades)
                </button>
            @else


                {{-- BOTÓN PARA ABRIR MODAL DE CONFIRMACIÓN --}}
                <button type="button"
                        x-data
                        @click="$dispatch('open-modal', 'modal-eliminar-control')"
                        class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                            bg-red-600 text-white hover:bg-red-700 transition">
                    Eliminar Control
                </button>


            @endif

        </div>

        {{-- ========================================================= --}}
        {{-- 🔴 MENSAJE DE ERROR SI NO PUDO ELIMINAR --}}
        {{-- ========================================================= --}}
        @if(session('error'))
            <div class="p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 shadow">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 shadow">
                {{ session('success') }}
            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- 🔵 HEADER PRINCIPAL DEL CONTROL --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6"
             style="background-color: var(--card); color: var(--card-foreground);">

            <h2 class="text-2xl font-bold mb-1">{{ $control->lugar }}</h2>

            <p class="text-sm" style="color: var(--muted-foreground)">
                <strong>Administrador:</strong> {{ $control->administrador->name ?? '—' }}<br>
                <strong>Ruta:</strong> {{ $control->ruta ?? '—' }}<br>
                <strong>Móvil asignado:</strong> {{ $control->movil_asignado ?? '—' }}
            </p>
        </div>

        {{-- ========================================================= --}}
        {{-- 🔵 TABS --}}
        {{-- ========================================================= --}}
        <div x-data="{ tab: 'info' }">

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

            {{-- ----------------------- TAB INFO --------------------- --}}
            <div x-show="tab=='info'" x-transition 
                class="shadow rounded-xl p-6"
                style="background: var(--card); color: var(--card-foreground);">

                <h3 class="text-xl font-bold mb-4">Información General</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>Fecha:</strong> {{ $control->fecha }}</p>
                    <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
                    <p><strong>Ruta:</strong> {{ $control->ruta ?? '—' }}</p>
                    <p><strong>Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>
                    <p><strong>Inicio:</strong> {{ $control->hora_inicio }}</p>
                    <p><strong>Fin:</strong> {{ $control->hora_fin }}</p>
                </div>
            </div>

            {{-- ----------------------- TAB PERSONAL --------------------- --}}
            <div x-show="tab=='personal'" x-transition 
                class="shadow rounded-xl p-6"
                style="background: var(--card); color: var(--card-foreground);">

                <h3 class="text-xl font-bold mb-4">Personal Asignado</h3>

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

            {{-- ----------------------- TAB VEHÍCULOS --------------------- --}}
            <div x-show="tab=='vehiculos'" x-transition 
                class="shadow rounded-xl p-6"
                style="background: var(--card); color: var(--card-foreground);">

                <h3 class="text-xl font-bold mb-4">Vehículos Requisados</h3>

                @forelse ($control->vehiculosControlados as $v)
                    <div class="border-b py-4" style="border-color: var(--border)">
                        <p class="font-semibold">
                            {{ $v->marca_modelo }} – {{ $v->dominio }}
                        </p>
                        <p class="text-sm">Conductor: <strong>{{ $v->conductor->nombre_apellido }}</strong></p>
                    </div>
                @empty
                    <p class="text-sm" style="color: var(--muted-foreground)">No se registraron vehículos.</p>
                @endforelse
            </div>

            {{-- ----------------------- TAB CIVILES --------------------- --}}
            <div x-show="tab=='civiles'" x-transition 
                class="shadow rounded-xl p-6"
                style="background: var(--card); color: var(--card-foreground);">

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

            {{-- ----------------------- TAB NOVEDADES --------------------- --}}
            <div x-show="tab=='novedades'" x-transition 
                class="shadow rounded-xl p-6"
                style="background: var(--card); color: var(--card-foreground);">

                <h3 class="text-xl font-bold mb-4">Novedades</h3>

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
                    <p class="text-sm" style="color: var(--muted-foreground)">No se registraron novedades.</p>
                @endunless
            </div>

            {{-- ----------------------- TAB PRODUCTIVIDAD --------------------- --}}
            <div x-show="tab=='productividad'" x-transition class="card p-6 rounded-xl shadow space-y-10">

                <h3 class="text-xl font-bold mb-4">Productividad del Operativo</h3>

                {{-- TOTALES --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="card p-4 shadow rounded-xl border-l-4 border-blue-600">
                        <p class="text-sm" style="color: var(--muted-foreground);">Vehículos controlados</p>
                        <h2 class="text-3xl font-extrabold mt-1">{{ $totalVehiculos }}</h2>
                    </div>

                    <div class="card p-4 shadow rounded-xl border-l-4 border-green-600">
                        <p class="text-sm" style="color: var(--muted-foreground);">Conductores</p>
                        <h2 class="text-3xl font-extrabold mt-1">{{ $totalConductores }}</h2>
                    </div>

                    <div class="card p-4 shadow rounded-xl border-l-4 border-yellow-500">
                        <p class="text-sm" style="color: var(--muted-foreground);">Acompañantes</p>
                        <h2 class="text-3xl font-extrabold mt-1">{{ $totalAcompanantes }}</h2>
                    </div>

                    <div class="card p-4 shadow rounded-xl border-l-4 border-red-600">
                        <p class="text-sm" style="color: var(--muted-foreground);">Novedades</p>
                        <h2 class="text-3xl font-extrabold mt-1">{{ $totalNovedades }}</h2>
                    </div>
                </div>

                {{-- GRAFICO --}}
                <div>
                    <h3 class="text-lg font-bold mb-4">Gráfico por Operador</h3>

                    <div class="w-full max-w-3xl mx-auto">
                        <canvas id="graficoOperadores" style="height: 260px;"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const style = getComputedStyle(document.documentElement);
                        new Chart(document.getElementById('graficoOperadores'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($graficoOperadores['labels']) !!},
                                datasets: [
                                    {
                                        label: 'Vehículos',
                                        data: {!! json_encode($graficoOperadores['vehiculos']) !!},
                                        backgroundColor: style.getPropertyValue('--primary')
                                    },
                                    {
                                        label: 'Acompañantes',
                                        data: {!! json_encode($graficoOperadores['acompanantes']) !!},
                                        backgroundColor: '#34d399'
                                    },
                                    {
                                        label: 'Novedades',
                                        data: {!! json_encode($graficoOperadores['novedades']) !!},
                                        backgroundColor: '#fbbf24'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: { ticks: { color: style.getPropertyValue('--foreground') }},
                                    y: { ticks: { color: style.getPropertyValue('--foreground') }},
                                },
                                plugins: {
                                    legend: {
                                        labels: { color: style.getPropertyValue('--foreground') }
                                    }
                                }
                            }
                        });
                    </script>
                </div>

            </div>

        </div>
    </div>


</x-app-layout>
{{-- ========================================================= --}}
{{-- 🔴 MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
{{-- ========================================================= --}}
<x-modal-simple name="modal-eliminar-control" maxWidth="md">

    <div class="p-6" style="background: var(--card); color: var(--card-foreground);">

        <h2 class="text-xl font-bold mb-4" style="color: var(--destructive);">
            ¿Eliminar Control Policial?
        </h2>

        <p class="text-sm mb-6" style="color: var(--muted-foreground);">
            Esta acción es <strong>permanente</strong>.
            Se eliminará todo el operativo, el personal asignado y los registros asociados.
            <br><br>
            ¿Confirmas que deseas continuar?
        </p>

        <div class="flex justify-end gap-4">

            {{-- CANCELAR --}}
            <button type="button"
                @click="$dispatch('close-modal', 'modal-eliminar-control')"
                class="px-4 py-2 rounded-lg font-semibold shadow
                       transition bg-[var(--muted)] text-[var(--muted-foreground)]
                       hover:opacity-80">
                Cancelar
            </button>

            {{-- FORMULARIO REAL DE ELIMINACIÓN --}}
            <form method="POST" action="{{ route('controles.destroy', $control) }}">
                @csrf
                @method('DELETE')

                <button
                    class="px-4 py-2 rounded-lg font-semibold shadow
                           bg-red-600 text-white hover:bg-red-700 transition">
                    Sí, eliminar
                </button>
            </form>

        </div>

    </div>

</x-modal-simple>
