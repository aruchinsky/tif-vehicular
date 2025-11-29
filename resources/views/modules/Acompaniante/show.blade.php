<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Información del Acompañante
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="card rounded-xl border shadow-lg p-6">

            <h3 class="text-lg font-semibold mb-6" style="color: var(--foreground)">
                Datos del Acompañante
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="font-bold" style="color: var(--foreground)">DNI</p>
                    <span>{{ $acompaniante->dni_acompaniante ?? '—' }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Nombre</p>
                    <span>{{ $acompaniante->nombre_apellido }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Domicilio</p>
                    <span>{{ $acompaniante->domicilio }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Tipo</p>
                    <span>{{ $acompaniante->tipo_acompaniante }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">ID Conductor</p>
                    <span>{{ $acompaniante->conductor_id }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Conductor</p>
                    <span>{{ $acompaniante->conductor->nombre_apellido ?? '—' }}</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('acompaniante.index') }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>

                <a href="{{ route('acompaniante.edit', $acompaniante->id) }}"
                   class="px-5 py-3 rounded-lg"
                   style="background: var(--accent); color: var(--accent-foreground)">
                    Editar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
