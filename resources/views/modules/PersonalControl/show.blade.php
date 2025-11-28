<x-app-layout>
    <x-slot name="header">
        Detalle del Personal de Control: {{ $personal_control->nombre_apellido }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">

                {{-- Título --}}
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    Información del Personal
                </h3>

                {{-- Datos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                    <div>
                        <span class="font-bold">ID:</span>
                        <p>{{ $personal_control->id }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Nombre y Apellido:</span>
                        <p>{{ $personal_control->nombre_apellido ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Legajo:</span>
                        <p>{{ $personal_control->lejago_personal ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">DNI:</span>
                        <p>{{ $personal_control->dni ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Jerarquía:</span>
                        <p>{{ $personal_control->jerarquia ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Rol en Control:</span>
                        <p>{{ $personal_control->rol_en_control ?? '—' }}</p>
                    </div>

                    {{-- 🆕 Campo Móvil agregado después de "Rol en Control" --}}
                    <div>
                        <span class="font-bold">Móvil:</span>
                        <p>{{ $personal_control->movil ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Fecha del Control:</span>
                        <p>{{ $personal_control->fecha_control ? \Carbon\Carbon::parse($personal_control->fecha_control)->format('d/m/Y') : '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Hora Inicio:</span>
                        <p>{{ $personal_control->hora_inicio ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Hora Fin:</span>
                        <p>{{ $personal_control->hora_fin ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Lugar:</span>
                        <p>{{ $personal_control->lugar ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Ruta:</span>
                        <p>{{ $personal_control->ruta ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Fecha de Creación:</span>
                        <p>{{ $personal_control->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <span class="font-bold">Última Actualización:</span>
                        <p>{{ $personal_control->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('personalcontrol.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Volver
                    </a>

                    <a href="{{ route('personalcontrol.edit', $personal_control->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        Editar
                    </a>

                    <form action="{{ route('personalcontrol.destroy', $personal_control->id) }}"
                          method="POST"
                          onsubmit="return confirm('¿Está seguro de eliminar este registro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
