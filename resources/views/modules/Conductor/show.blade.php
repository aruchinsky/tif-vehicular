<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Detalle del Conductor
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="card shadow-lg border rounded-xl p-6">

            <h3 class="text-lg font-semibold mb-6" style="color: var(--foreground)">
                Información del Conductor
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="font-bold" style="color: var(--foreground)">ID</p>
                    <span>{{ $conductor->id }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Nombre</p>
                    <span>{{ $conductor->nombre_apellido }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">DNI</p>
                    <span>{{ $conductor->dni_conductor }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Domicilio</p>
                    <span>{{ $conductor->domicilio ?? '—' }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Categoría Carnet</p>
                    <span>{{ $conductor->categoria_carnet ?? '—' }}</span>
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Tipo</p>
                    <span>{{ $conductor->tipo_conductor ?? '—' }}</span>
                </div>

                {{-- Vehículos asociados --}}
                <div class="md:col-span-2">
                    <p class="font-bold" style="color: var(--foreground)">Vehículos Asociados</p>
                    @if($conductor->vehiculos->count() > 0)
                        <ul class="list-disc ml-6 mt-2 space-y-1">
                            @foreach($conductor->vehiculos as $veh)
                                <li>{{ $veh->marca_modelo }} — {{ $veh->dominio }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span>—</span>
                    @endif
                </div>

                <div>
                    <p class="font-bold" style="color: var(--foreground)">Destino</p>
                    <span>{{ $conductor->destino ?? '—' }}</span>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('conductores.index') }}"
                    class="px-5 py-3 rounded-lg"
                    style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>

                <a href="{{ route('conductores.edit', $conductor->id) }}"
                    class="px-5 py-3 rounded-lg"
                    style="background: var(--accent); color: var(--accent-foreground)">
                    Editar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
