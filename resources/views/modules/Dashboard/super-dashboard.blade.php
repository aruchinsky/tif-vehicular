{{-- resources/views/dashboard/super-dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        Panel del Superusuario
    </x-slot>

    <div class="space-y-10">

        {{-- ========================================================= --}}
        {{-- ======================  KPIs PRINCIPALES  ================= --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            @php
                $kpis = [
                    ['label' => 'Controles del Mes', 'value' => $stats['controles_mes'], 'color' => 'blue'],
                    ['label' => 'Vehículos Controlados', 'value' => $stats['vehiculos_mes'], 'color' => 'green'],
                    ['label' => 'Civiles Registrados', 'value' => $stats['civiles_mes'], 'color' => 'yellow'],
                    ['label' => 'Alertas Críticas (48h)', 'value' => $stats['alertas_48h'], 'color' => 'red'],
                ];
            @endphp

            @foreach ($kpis as $kpi)
                <div class="shadow rounded-xl p-6 border-l-4"
                     style="background: var(--card); color: var(--foreground); border-color: var(--{{ $kpi['color'] }}-600);">

                    <p class="text-sm font-semibold" style="color: var(--muted-foreground);">
                        {{ $kpi['label'] }}
                    </p>

                    <h2 class="text-3xl font-extrabold mt-1">
                        {{ $kpi['value'] }}
                    </h2>
                </div>
            @endforeach
        </div>


        {{-- ========================================================= --}}
        {{-- =================== ALERTAS EN TIEMPO REAL =============== --}}
        {{-- ========================================================= --}}
        <div x-data="alertasRealtime()" x-init="init()"
             class="shadow rounded-xl p-6"
             style="background: var(--card); color: var(--foreground);">

            <h3 class="text-xl font-bold mb-4">Alertas en Tiempo Real</h3>

            <template x-if="alertas.length === 0">
                <p class="text-sm" style="color: var(--muted-foreground);">
                    No hay alertas activas en este momento.
                </p>
            </template>

            <template x-for="item in alertas" :key="'alert-'+item.uid">
                <div class="p-4 mb-3 rounded border-l-4"
                     style="background: rgba(255,0,0,0.06); border-color:#dc2626;">

                    <p class="font-bold uppercase text-red-600">
                        🚨 <span x-text="item.tipo"></span>
                    </p>

                    <p class="text-sm text-[var(--muted-foreground)]">
                        Vehículo: <span x-text="item.dominio"></span>
                    </p>

                    <p class="text-sm text-[var(--muted-foreground)]">
                        Hora: <span x-text="item.hora"></span>
                    </p>

                    <div class="mt-2 text-right">
                        <a :href="'/controles/' + item.control"
                           class="px-3 py-1 rounded text-xs font-semibold"
                           style="background:#dc2626; color:white;">
                            Ver Operativo
                        </a>
                    </div>
                </div>
            </template>
        </div>


        {{-- ========================================================= --}}
        {{-- ================= CONTROLES ACTIVOS (HOY) ================ --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6"
             style="background: var(--card); color: var(--foreground);">

            <h3 class="text-xl font-bold mb-4">Controles Policiales Activos (Hoy)</h3>

            @if ($controlesHoy->isEmpty())
                <p class="text-sm" style="color: var(--muted-foreground);">
                    No hay operativos registrados para hoy.
                </p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($controlesHoy as $c)
                        <div class="p-4 rounded-xl shadow border"
                             style="background: var(--card); border-color: var(--border);">

                            <p class="font-bold text-lg">{{ $c->lugar }}</p>

                            <p class="text-sm" style="color: var(--muted-foreground);">
                                Ruta: {{ $c->ruta ?? '—' }}
                            </p>

                            <p class="text-sm" style="color: var(--muted-foreground);">
                                Horario: {{ $c->hora_inicio }} – {{ $c->hora_fin }}
                            </p>

                            <p class="text-sm" style="color: var(--muted-foreground);">
                                Vehículos: {{ $c->vehiculosControlados->count() }}
                            </p>

                            <div class="mt-3 text-right">
                                <a href="{{ route('controles.show', $c) }}"
                                   class="px-3 py-1 rounded text-sm font-semibold"
                                   style="background: var(--primary); color: var(--primary-foreground);">
                                    Ver Detalle
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>


        {{-- ========================================================= --}}
        {{-- =============== BLOQUE EN DOS COLUMNAS (RESPONSIVE) ====== --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ========================================================= --}}
            {{-- =============== PRODUCTIVIDAD GLOBAL (GRÁFICO) ============ --}}
            {{-- ========================================================= --}}
            <div class="shadow rounded-xl p-6"
                style="background-color: var(--card); color: var(--foreground);">

                <h3 class="text-xl font-bold mb-4">Productividad (Últimos 30 días)</h3>

                {{-- Ajustamos altura y tamaño del canvas --}}
                <div class="relative h-56"> {{-- antes h-120 --}}
                    <canvas id="graficoProductividadSuper"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {

                        const ctx = document.getElementById('graficoProductividadSuper');
                        const style = getComputedStyle(document.documentElement);

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($grafico['labels']) !!},
                                datasets: [
                                    {
                                        label: 'Vehículos',
                                        data: {!! json_encode($grafico['vehiculos']) !!},
                                        borderColor: style.getPropertyValue('--primary'),
                                        borderWidth: 2,
                                        tension: 0.3
                                    },
                                    {
                                        label: 'Conductores',
                                        data: {!! json_encode($grafico['conductores']) !!},
                                        borderColor: '#16a34a',
                                        borderWidth: 2,
                                        tension: 0.3
                                    },
                                    {
                                        label: 'Acompañantes',
                                        data: {!! json_encode($grafico['acompanantes']) !!},
                                        borderColor: '#f59e0b',
                                        borderWidth: 2,
                                        tension: 0.3
                                    }
                                ]
                            },
                            options: {
                                maintainAspectRatio: false, // permite ajustar altura final
                                plugins: {
                                    legend: {
                                        labels: { color: style.getPropertyValue('--foreground') }
                                    }
                                },
                                scales: {
                                    x: { ticks: { color: style.getPropertyValue('--foreground') }},
                                    y: { ticks: { color: style.getPropertyValue('--foreground') }},
                                }
                            }
                        });
                    });
                </script>
            </div>


            {{-- ========================================================= --}}
            {{-- =============== PANEL COMPLEMENTARIO (DERECHA) ============ --}}
            {{-- ========================================================= --}}
            <div class="shadow rounded-xl p-6 flex flex-col justify-between"
                style="background-color: var(--card); color: var(--foreground);">

                <h3 class="text-xl font-bold mb-4">Resumen de Actividad del Mes</h3>

                <ul class="space-y-3 text-sm">

                    <li class="flex justify-between">
                        <span style="color: var(--muted-foreground);">Total de controles:</span>
                        <strong>{{ $stats['controles_mes'] }}</strong>
                    </li>

                    <li class="flex justify-between">
                        <span style="color: var(--muted-foreground);">Vehículos controlados:</span>
                        <strong>{{ $stats['vehiculos_mes'] }}</strong>
                    </li>

                    <li class="flex justify-between">
                        <span style="color: var(--muted-foreground);">Civiles registrados:</span>
                        <strong>{{ $stats['civiles_mes'] }}</strong>
                    </li>

                    <li class="flex justify-between">
                        <span style="color: var(--muted-foreground);">Alertas críticas 48h:</span>
                        <strong class="text-red-600">{{ $stats['alertas_48h'] }}</strong>
                    </li>

                </ul>

                <div class="mt-6 pt-4 border-t" style="border-color: var(--border);">
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        Este panel complementa el gráfico permitiendo visualizar los totales del mes de forma inmediata.
                    </p>
                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- =================== PANEL DE CONFIGURACIÓN =============== --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6"
             style="background: var(--card); color: var(--foreground);">

            <h3 class="text-xl font-bold mb-4">Gestión Avanzada del Sistema</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <a href="{{ route('cargos-policiales.index') }}"
                   class="block p-4 rounded-xl shadow hover:bg-[var(--muted)] transition">
                    <p class="font-bold text-lg">Cargos Policiales</p>
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        Administrar roles operativos usados en los controles.
                    </p>
                </a>

                <a href="{{ route('controles.index') }}"
                   class="block p-4 rounded-xl shadow hover:bg-[var(--muted)] transition">
                    <p class="font-bold text-lg">Controles Policiales</p>
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        Gestión completa de operativos.
                    </p>
                </a>

                <a href="{{ route('productividad.index') }}"
                   class="block p-4 rounded-xl shadow hover:bg-[var(--muted)] transition">
                    <p class="font-bold text-lg">Productividad</p>
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        Ver estadísticas por agente.
                    </p>
                </a>

            </div>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ===================== JS ALERTAS REALTIME ================ --}}
    {{-- ========================================================= --}}
    <script>
        function alertasRealtime() {
            return {
                alertas: [],

                init() {
                    // Suscripción al store global de notificaciones
                    window.NotificacionesStore.subscribe((lista) => {
                        this.alertas = lista.slice(0, 10);
                    });
                }
            };
        }
    </script>

</x-app-layout>
