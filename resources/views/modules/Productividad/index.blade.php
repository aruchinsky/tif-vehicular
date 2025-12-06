<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Panel de Productividad — Superusuario
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

        {{-- ======================================================
            🔥 KPI GLOBAL
        ======================================================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-xl p-4 shadow border"
                style="background: var(--primary); color: var(--primary-foreground);">
                <p class="text-xs opacity-80">Vehículos Registrados</p>
                <p class="text-2xl font-extrabold">{{ $kpi['vehiculos'] }}</p>
            </div>

            <div class="rounded-xl p-4 shadow border"
                style="background: var(--accent); color: var(--accent-foreground);">
                <p class="text-xs opacity-80">Conductores Registrados</p>
                <p class="text-2xl font-extrabold">{{ $kpi['conductores'] }}</p>
            </div>

            <div class="rounded-xl p-4 shadow border"
                style="background: var(--secondary); color: var(--secondary-foreground);">
                <p class="text-xs opacity-80">Acompañantes</p>
                <p class="text-2xl font-extrabold">{{ $kpi['acompanantes'] }}</p>
            </div>

            <div class="rounded-xl p-4 shadow border"
                style="background: var(--card); color: var(--foreground);">
                <p class="text-xs opacity-80">Novedades Emitidas</p>
                <p class="text-2xl font-extrabold">{{ $kpi['novedades'] }}</p>
            </div>

        </div>

        {{-- ======================================================
            📈 EVOLUCIÓN DIARIA
        ======================================================= --}}
        <div class="shadow rounded-xl border p-4">
            <h3 class="text-base font-semibold mb-3" style="color: var(--foreground);">
                Evolución General del Sistema
            </h3>

            <div class="h-52 md:h-64 lg:h-72">
                <canvas id="evolucionChart"></canvas>
            </div>
        </div>

        {{-- ======================================================
            📉 RANKING OPERADORES
        ======================================================= --}}
        <div class="shadow rounded-xl border p-4">
            <h3 class="text-base font-semibold mb-3" style="color: var(--foreground);">
                Ranking de Productividad por Personal
            </h3>

            <div class="h-52 md:h-64 lg:h-72">
                <canvas id="rankingChart"></canvas>
            </div>
        </div>

        {{-- ======================================================
            🥧 TIPO DE REGISTROS
        ======================================================= --}}
        <div class="shadow rounded-xl border p-4">
            <h3 class="text-base font-semibold mb-3" style="color: var(--foreground);">
                Distribución Global de Registros
            </h3>

            <div class="flex justify-center">
                <div class="h-40 w-40 md:h-48 md:w-48">
                    <canvas id="tortaChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ======================================================
            🏆 TABLA RANKING
        ======================================================= --}}
        <div class="shadow rounded-xl border overflow-hidden">
            <div class="p-3 border-b" style="background: var(--muted);">
                <h3 class="text-base font-semibold" style="color: var(--muted-foreground);">
                    Ranking General
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs md:text-sm">
                    <thead>
                        <tr style="background: var(--card)">
                            <th class="px-4 py-2 text-left">Personal</th>
                            <th class="px-4 py-2 text-left">Cond.</th>
                            <th class="px-4 py-2 text-left">Vehíc.</th>
                            <th class="px-4 py-2 text-left">Acomp.</th>
                            <th class="px-4 py-2 text-left">Nov.</th>
                            <th class="px-4 py-2 text-left font-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking as $r)
                        <tr class="border-b" style="border-color: var(--border);">
                            <td class="px-4 py-2 font-semibold">{{ $r->nombre }}</td>
                            <td class="px-4 py-2">{{ $r->conductores }}</td>
                            <td class="px-4 py-2">{{ $r->vehiculos }}</td>
                            <td class="px-4 py-2">{{ $r->acompanantes }}</td>
                            <td class="px-4 py-2">{{ $r->novedades }}</td>
                            <td class="px-4 py-2 font-bold">{{ $r->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ======================================================
            🚨 ANOMALÍAS
        ======================================================= --}}
        <div class="shadow rounded-xl border p-4">
            <h3 class="text-base font-semibold mb-3" style="color: var(--foreground);">
                Anomalías Detectadas
            </h3>

            @if(empty($anomalias))
                <p class="text-sm text-[var(--muted-foreground)]">No se detectaron anomalías.</p>
            @else
                <ul class="list-disc pl-6 space-y-1 text-xs md:text-sm">
                    @foreach($anomalias as $a)
                        <li>{{ $a }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <script>
        new Chart(document.getElementById('evolucionChart'), {
            type: 'line',
            data: {
                labels: @json($evolucion['fechas']),
                datasets: [{
                    label: "Total por Día",
                    data: @json($evolucion['totales']),
                    borderColor: 'rgb(59,130,246)',
                    backgroundColor: 'rgba(59,130,246,0.25)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('rankingChart'), {
            type: 'bar',
            data: {
                labels: @json($ranking->pluck('nombre')),
                datasets: [{
                    label: "Total",
                    data: @json($ranking->pluck('total')),
                    backgroundColor: 'rgba(234,88,12,0.7)',
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        new Chart(document.getElementById('tortaChart'), {
            type: 'doughnut',
            data: {
                labels: ["Conductores", "Vehículos", "Acompañantes", "Novedades"],
                datasets: [{
                    data: @json($torta),
                    backgroundColor: [
                        'rgba(59,130,246,0.7)',
                        'rgba(234,179,8,0.7)',
                        'rgba(16,185,129,0.7)',
                        'rgba(239,68,68,0.7)'
                    ]
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>
    @endpush
</x-app-layout>
