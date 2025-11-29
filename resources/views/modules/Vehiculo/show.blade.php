<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Detalle del Vehículo
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="card shadow-lg border rounded-xl p-6 space-y-6">

            <h3 class="text-lg font-semibold" style="color: var(--foreground)">
                Información General
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">ID</p>
                    <p class="font-medium" style="color: var(--foreground)">{{ $vehiculo->id }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Conductor</p>
                    <p class="font-medium" style="color: var(--foreground)">
                        {{ $vehiculo->conductor->nombre_apellido ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Personal de Control</p>
                    <p class="font-medium" style="color: var(--foreground)">
                        {{ $vehiculo->personalControl->nombre_apellido ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Fecha y Hora</p>
                    <p class="font-medium" style="color: var(--foreground)">
                        {{ \Carbon\Carbon::parse($vehiculo->fecha_hora_control)->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Marca / Modelo</p>
                    <p class="font-medium" style="color: var(--foreground)">{{ $vehiculo->marca_modelo }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Dominio</p>
                    <p class="font-medium" style="color: var(--foreground)">{{ $vehiculo->dominio }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold" style="color: var(--muted-foreground)">Color</p>
                    <p class="font-medium" style="color: var(--foreground)">{{ $vehiculo->color ?? '—' }}</p>
                </div>

            </div>

            <div class="flex justify-end gap-4">

                <a href="{{ route('vehiculo.index') }}"
                    class="px-4 py-2 rounded-lg"
                    style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>

                @role('ADMINISTRADOR')
                <a href="{{ route('vehiculo.edit', $vehiculo->id) }}"
                    class="px-4 py-2 rounded-lg"
                    style="background: var(--accent); color: var(--accent-foreground)">
                    Editar
                </a>
                @endrole

            </div>

        </div>

    </div>
</x-app-layout>
