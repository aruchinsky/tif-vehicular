<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Panel del Superusuario</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4">

        <div class="card p-6 shadow rounded-xl">
            <h3 class="text-xl font-bold mb-4">Últimos Controles Registrados</h3>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-3 text-left">Fecha</th>
                        <th class="text-left">Lugar</th>
                        <th class="text-left">Ruta</th>
                        <th class="text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($controles as $control)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3">{{ $control->fecha }}</td>
                            <td>{{ $control->lugar }}</td>
                            <td>{{ $control->ruta }}</td>
                            <td>
                                <a href="{{ route('controles.show', $control) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</x-app-layout>
