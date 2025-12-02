<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Tus Operativos Asignados</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4">

        @if (!$personal)
            <div class="card p-8 text-center">
                <p class="text-xl font-semibold">No estás asignado a ningún operativo.</p>
                <p class="text-gray-500 mt-2">Contactá a tu jefe de unidad.</p>
            </div>
        @else

            <h3 class="text-2xl font-bold mb-6">Hola, {{ $personal->nombre_apellido }}</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                @foreach ($controles as $control)
                    <div class="card p-6 shadow rounded-xl">
                        <h4 class="text-lg font-bold mb-2">Operativo del {{ $control->fecha }}</h4>

                        <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
                        <p><strong>Ruta:</strong> {{ $control->ruta ?? '—' }}</p>
                        <p><strong>Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>

                        <div class="text-right mt-4">
                            <a href="{{ route('controles.show', $control->id) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded">
                                Abrir Operativo
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

        @endif

    </div>

</x-app-layout>
