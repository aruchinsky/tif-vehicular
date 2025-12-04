<x-app-layout>
    <x-slot name="header">
        Panel del Administrador
    </x-slot>

    <div class="space-y-10">

        {{-- ========================================================= --}}
        {{-- =====================  KPIs PRINCIPALES ================== --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            {{-- KPI TEMPLATE --}}
            @php
                $kpis = [
                    ['label' => 'Controles del mes', 'value' => $stats['controles_mes'], 'color' => 'blue'],
                    ['label' => 'Vehículos controlados', 'value' => $stats['vehiculos_mes'], 'color' => 'green'],
                    ['label' => 'Civiles registrados', 'value' => $stats['civiles_mes'], 'color' => 'yellow'],
                    ['label' => 'Alertas graves (48h)', 'value' => $stats['alertas_48h'], 'color' => 'red'],
                ];
            @endphp

            @foreach ($kpis as $kpi)
                <div class="shadow rounded-xl p-6 border-l-4"
                     style="
                        background-color: var(--card);
                        color: var(--card-foreground);
                        border-color: var(--{{ $kpi['color'] }}-600);
                     ">
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        {{ $kpi['label'] }}
                    </p>

                    <h2 class="text-3xl font-extrabold mt-1">
                        {{ $kpi['value'] }}
                    </h2>
                </div>
            @endforeach

        </div>

        {{-- ========================================================= --}}
        {{-- ====================== ALERTAS URGENTES ================== --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6"
             style="background-color: var(--card); color: var(--card-foreground);">

            <h3 class="text-xl font-bold mb-4"
                style="color: var(--foreground);">
                Alertas Importantes
            </h3>

            @forelse ($alertas as $n)

                <div class="grid grid-cols-12 gap-4 p-4 mb-3 rounded relative overflow-hidden"
                     style="
                        background: rgba(255, 0, 0, 0.05);
                        border-left: 4px solid #dc2626;
                     ">

                    <div class="col-span-10">
                        <p class="font-semibold uppercase" style="color: #dc2626;">
                            {{ $n->tipo_novedad }} ({{ $n->aplica }})
                        </p>
                        <p class="text-sm" style="color: var(--muted-foreground);">
                            {{ $n->observaciones }}
                        </p>
                    </div>

                    <div class="col-span-2 text-right flex items-center justify-end">
                        <a href="{{ route('controles.show', $n->vehiculo->control_id ?? null) }}"
                           class="px-3 py-1 text-xs rounded font-semibold"
                           style="background:#dc2626; color:white;">
                            Ver Operativo
                        </a>
                    </div>

                </div>

            @empty
                <p class="text-sm" style="color: var(--muted-foreground);">No hay alertas recientes.</p>
            @endforelse
        </div>

        {{-- ========================================================= --}}
        {{-- ================= GESTIÓN DE CONTROLES =================== --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6"
             style="background-color: var(--card); color: var(--card-foreground);">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" style="color: var(--foreground);">
                    Gestión de Controles Policiales
                </h3>

                <a href="{{ route('controles.create') }}"
                   class="px-4 py-2 rounded-lg font-semibold shadow"
                   style="background: var(--primary); color: var(--primary-foreground);">
                    + Nuevo Control
                </a>
            </div>

            @if ($controles->isEmpty())

                <p class="text-center text-lg" style="color: var(--muted-foreground);">
                    No hay controles registrados.
                </p>

            @else

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b" style="border-color: var(--border);">
                            <th class="py-3 text-left">Fecha</th>
                            <th class="text-left">Lugar</th>
                            <th class="text-left">Ruta</th>
                            <th class="text-left">Móvil</th>
                            <th class="text-left">Estado</th>
                            <th class="text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($controles as $control)
                            @php
                                $vehiculos = $control->vehiculosControlados->count();
                                $estadoColor = $vehiculos === 0
                                    ? 'background:var(--muted); color:var(--foreground);'
                                    : 'background:#bbf7d0; color:#065f46;';
                            @endphp

                            <tr class="border-b hover:bg-[var(--muted)] transition"
                                style="border-color: var(--border);">

                                <td class="py-3">{{ $control->fecha }}</td>
                                <td>{{ $control->lugar }}</td>
                                <td>{{ $control->ruta ?? '—' }}</td>
                                <td>{{ $control->movil_asignado ?? '—' }}</td>

                                <td>
                                    <span class="px-2 py-1 rounded text-xs font-semibold"
                                          style="{{ $estadoColor }}">
                                        {{ $vehiculos === 0 ? 'Sin actividad' : 'Con actividad' }}
                                    </span>
                                </td>

                                <td class="text-right space-x-2">

                                    <a href="{{ route('controles.show', $control) }}"
                                    class="px-3 py-1 rounded bg-[var(--primary)] text-[var(--primary-foreground)] text-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('controles.edit', $control) }}"
                                    class="px-3 py-1 rounded bg-[var(--secondary)] text-white text-sm">
                                        Editar
                                    </a>

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif

        </div>

{{-- ========================================================= --}}
{{-- ================= GRÁFICO DE PRODUCTIVIDAD COMPLETO ===== --}}
{{-- ========================================================= --}}
<div class="shadow rounded-xl p-6"
     style="background-color: var(--card); color: var(--card-foreground);">

    <h3 class="text-xl font-bold mb-4" style="color: var(--foreground);">
        Productividad General (Últimos 30 días)
    </h3>

    <canvas id="graficoProductividad" height="120"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctxProd = document.getElementById('graficoProductividad');

        const style = getComputedStyle(document.documentElement);
        const colorVehiculos     = style.getPropertyValue('--primary').trim();
        const colorConductores   = '#16a34a';
        const colorAcompanantes  = '#f59e0b';
        const colorText          = style.getPropertyValue('--foreground').trim();

        new Chart(ctxProd, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafico['labels']) !!},
                datasets: [
                    {
                        label: 'Vehículos Controlados',
                        data: {!! json_encode($grafico['vehiculos']) !!},
                        borderColor: colorVehiculos,
                        borderWidth: 3,
                        tension: 0.3
                    },
                    {
                        label: 'Conductores Registrados',
                        data: {!! json_encode($grafico['conductores']) !!},
                        borderColor: colorConductores,
                        borderWidth: 3,
                        tension: 0.3
                    },
                    {
                        label: 'Acompañantes Registrados',
                        data: {!! json_encode($grafico['acompanantes']) !!},
                        borderColor: colorAcompanantes,
                        borderWidth: 3,
                        tension: 0.3
                    },
                ]
            },
            options: {
                plugins: {
                    legend: {
                        labels: { color: colorText }
                    }
                },
                scales: {
                    x: { ticks: { color: colorText } },
                    y: { ticks: { color: colorText } },
                }
            }
        });
    </script>
</div>
</div>

</x-app-layout>
