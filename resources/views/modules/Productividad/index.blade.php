<x-app-layout>
    {{-- 🔹 Header con navegación --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Panel de Productividad (Administrador)
            </h2>
        </div>
         @include('partials._tabs_navigation')
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ Mensaje de éxito (Se mantiene por si acaso) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 📊 SECCIÓN DE GRÁFICO DIARIO DE PRODUCTIVIDAD --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
                    Productividad Total Diaria por Tipo de Registro
                </h3>
                <canvas id="dailyProductivityChart" height="100"></canvas>
            </div>


            {{-- 📋 TABLA (Se mantiene para ver los registros individuales por personal) --}}
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">
                Registros Individuales (Detalle)
            </h3>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Personal Control</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Conductores Registrados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Vehículos Registrados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acompañantes Registrados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($productividades as $productividad)
                            <tr>
                                <td class="px-6 py-4">{{ $productividad->id }}</td>
                                <td class="px-6 py-4">
                                    {{ $productividad->personalcontrol->nombre_apellido ?? '—' }} (ID: {{ $productividad->personal_control_id }})
                                </td>
                                <td class="px-6 py-4">{{ $productividad->fecha }}</td>
                                <td class="px-6 py-4">{{ $productividad->total_conductor ?? 0 }}</td>
                                <td class="px-6 py-4">{{ $productividad->total_vehiculos ?? 0 }}</td>
                                <td class="px-6 py-4">{{ $productividad->total_acompanante ?? 0 }}</td>
                                {{-- Quitamos acciones de CRUD manuales --}}
                                <td class="px-6 py-4 text-gray-400">—</td> 
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    No hay registros de productividad aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $productividades->links() }}
                </div>
            </div>

        </div>
    </div>
    
    {{-- ⚙️ Script de Chart.js --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dailyProductivityChart');

            const data = {
                labels: @json($fechas),
                datasets: [
                    {
                        label: 'Conductores Registrados',
                        data: @json($conductores),
                        backgroundColor: 'rgba(59, 130, 246, 0.7)', // Indigo-500
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Vehículos Registrados',
                        data: @json($vehiculos),
                        backgroundColor: 'rgba(234, 179, 8, 0.7)', // Yellow-500
                        borderColor: 'rgb(234, 179, 8)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Acompañantes Registrados',
                        data: @json($acompanantes),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)', // Green-500
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            };

            new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total de Registros'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha (Día/Mes)'
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

{{-- Nota: Si usas Laravel Jetstream/Breeze, asegúrate de que tu layout base (app.blade.php) incluya la directiva @stack('scripts') antes de la etiqueta de cierre </body>. --}}

