<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Detalle de Novedad
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="card shadow-lg rounded-xl border p-6">

            <h3 class="text-lg font-semibold mb-6" style="color: var(--foreground)">
                Información de la Novedad
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="font-bold" style="color: var(--foreground)">ID</p>
                    <span>{{ $novedad->id }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Vehículo</p>
                    <span>
                        {{ $novedad->vehiculo->marca_modelo ?? '—' }}
                        ({{ $novedad->vehiculo->dominio ?? '' }})
                    </span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Tipo de Novedad</p>
                    <span>{{ $novedad->tipo_novedad }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Aplica</p>
                    <span>{{ $novedad->aplica }}</span>
                </div>

                <div class="md:col-span-2">
                    <p class="font-bold" style="color: var(--foreground)">Observaciones</p>
                    <span>{{ $novedad->observaciones ?? '—' }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Creada</p>
                    <span>{{ $novedad->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Última actualización</p>
                    <span>{{ $novedad->updated_at->format('d/m/Y H:i') }}</span>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('novedades.index') }}"
                    class="px-5 py-3 rounded-lg"
                    style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>

                <a href="{{ route('novedades.edit', $novedad->id) }}"
                    class="px-5 py-3 rounded-lg"
                    style="background: var(--accent); color: var(--accent-foreground)">
                    Editar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
