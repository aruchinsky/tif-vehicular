<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Detalle de Novedad
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">

        <div class="shadow rounded-xl border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-bold mb-6" style="color: var(--foreground);">
                Información General
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="font-semibold">Vehículo</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $novedad->vehiculo->marca_modelo ?? '—' }}
                        ({{ $novedad->vehiculo->dominio ?? '' }})
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Tipo de Novedad</p>
                    <p class="text-[var(--muted-foreground)]">{{ $novedad->tipo_novedad }}</p>
                </div>

                <div>
                    <p class="font-semibold">Aplica</p>
                    <p class="text-[var(--muted-foreground)]">{{ $novedad->aplica ?? '—' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="font-semibold">Observaciones</p>
                    <p class="text-[var(--muted-foreground)]">{{ $novedad->observaciones ?? '—' }}</p>
                </div>

                <div>
                    <p class="font-semibold">Registrada el</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $novedad->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Última actualización</p>
                    <p class="text-[var(--muted-foreground)]">
                        {{ $novedad->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('novedades.index') }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--muted); color: var(--muted-foreground);">
                    Volver
                </a>

                <a href="{{ route('novedades.edit', $novedad) }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--accent); color: var(--accent-foreground);">
                    Editar
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
