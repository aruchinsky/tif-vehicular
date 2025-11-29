<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Productividad General del Sistema
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- 📊 TARJETA DEL GRÁFICO PRINCIPAL --}}
        <div class="card border shadow-lg rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground)">
                Evolución Diaria de Registros
            </h3>

            <div style="position: relative; height: 350px;">
                <canvas id="productividadChart"></canvas>
            </div>
        </div>


        {{-- 📋 TABLA DE REGISTROS INDIVIDUALES --}}
        <div class="card border shadow-lg rounded-xl overflow-hidden">

            <div class="p-4 border-b" style="background: var(--muted)">
                <h3 class="text-lg font-semibold" style="color: var(--muted-foreground)">
                    Registros Individuales por Personal
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead style="background: var(--card)">
                        <tr>
                            @foreach(['ID','Personal','Fecha','Conductores','Vehículos','Acompañantes'] as $head)
                                <th class="px-6 py-3 text-left font-bold uppercase tracking-wide"
                                    style="color: var(--muted-foreground)">
                                    {{ $head }}
                                </th>
                            @endforeach

                            {{-- COLUMNA EXTRA SOLO SI ES ADMIN --}}
                            @if(auth()->user()->role_id === 1)
                                <th class="px-6 py-3 text-left font-bold uppercase tracking-wide"
                                    style="color: var(--muted-foreground)">
                                    Acción
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($productividades as $p)
                            <tr class="border-b" style="border-color: var(--border)">
                                <td class="px-6 py-4">{{ $p->id }}</td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $p->personalControl->nombre_apellido ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4">{{ $p->total_conductor }}</td>
                                <td class="px-6 py-4">{{ $p->total_vehiculos }}</td>
                                <td class="px-6 py-4">{{ $p->total_acompanante }}</td>

                                {{-- BOTÓN VER SOLO PARA ADMIN --}}
                                @if(auth()->user()->role_id === 1)
                                    <td class="px-6 py-4">
                                        <a href="{{ route('productividad.show', $p->id) }}"
                                           class="px-3 py-1 rounded-lg text-xs font-semibold"
                                           style="background: var(--accent); color: var(--accent-foreground)">
                                            Ver
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center" style="color: var(--muted-foreground)">
                                    No hay registros disponibles.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="p-4">
                {{ $productividades->links() }}
            </div>

        </div>

    </div>

    {{-- 📊 SCRIPT CHART JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const ctx = document.getElementById('productividadChart');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($fechas),
                        datasets: [
                            {
                                label: 'Conductores',
                                data: @json($conductores),
                                borderColor: 'rgb(59,130,246)',
                                backgroundColor: 'rgba(59,130,246,0.25)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true,
                            },
                            {
                                label: 'Vehículos',
                                data: @json($vehiculos),
                                borderColor: 'rgb(234,179,8)',
                                backgroundColor: 'rgba(234,179,8,0.25)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true,
                            },
                            {
                                label: 'Acompañantes',
                                data: @json($acompanantes),
                                borderColor: 'rgb(16,185,129)',
                                backgroundColor: 'rgba(16,185,129,0.25)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--foreground')
                                }
                            },
                            y: {
                                ticks: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--foreground')
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--foreground')
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

    @stack('scripts')
</x-app-layout>
