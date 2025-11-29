<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Detalle del Personal: {{ $personal_control->nombre_apellido }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="card shadow-lg border rounded-xl p-6">

            <h3 class="text-lg font-semibold mb-6" style="color: var(--foreground)">
                Información del Personal
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach([
                    'ID' => $personal_control->id,
                    'Nombre y Apellido' => $personal_control->nombre_apellido,
                    'Legajo' => $personal_control->lejago_personal,
                    'DNI' => $personal_control->dni,
                    'Jerarquía' => $personal_control->jerarquia,
                    'Cargo Policial' => $personal_control->cargo->nombre ?? '—',
                    'Móvil' => $personal_control->movil,
                    'Fecha de Control' => $personal_control->fecha_control,
                    'Hora Inicio' => $personal_control->hora_inicio,
                    'Hora Fin' => $personal_control->hora_fin,
                    'Lugar' => $personal_control->lugar,
                    'Ruta' => $personal_control->ruta,
                ] as $label => $value)

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">{{ $label }}</p>
                    <p style="color: var(--foreground)" class="font-medium">{{ $value ?: '—' }}</p>
                </div>

                @endforeach

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Creado</p>
                    <p style="color: var(--foreground)">
                        {{ $personal_control->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Actualizado</p>
                    <p style="color: var(--foreground)">
                        {{ $personal_control->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('personalcontrol.index') }}"
                   class="px-4 py-2 rounded-lg"
                   style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>

                <a href="{{ route('personalcontrol.edit', $personal_control->id) }}"
                   class="px-4 py-2 rounded-lg"
                   style="background: var(--accent); color: var(--accent-foreground)">
                    Editar
                </a>

                <form action="{{ route('personalcontrol.destroy', $personal_control->id) }}"
                      method="POST"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg"
                        style="background: var(--destructive); color: white">
                        Eliminar
                    </button>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>
