<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground);">
            Vehículo — {{ $vehiculo->dominio }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 space-y-8">

        <a href="{{ route('vehiculo.index') }}"
            class="text-sm px-4 py-2 rounded bg-[var(--muted)] text-[var(--muted-foreground)] hover:opacity-80">
            ← Volver
        </a>

        <div class="shadow rounded-xl p-6 border"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-xl font-semibold mb-4">Información del Vehículo</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                <p><strong>Dominio:</strong> {{ $vehiculo->dominio }}</p>
                <p><strong>Modelo:</strong> {{ $vehiculo->marca_modelo }}</p>
                <p><strong>Color:</strong> {{ $vehiculo->color ?? '—' }}</p>
                <p><strong>Fecha control:</strong> 
                    {{ \Carbon\Carbon::parse($vehiculo->fecha_hora_control)->format('d/m/Y H:i') }}
                </p>

                <p><strong>Conductor:</strong> {{ $vehiculo->conductor->nombre_apellido }}</p>

                <p><strong>Operador:</strong>
                    {{ $vehiculo->operador->nombre_apellido ?? '—' }}
                </p>

                <p><strong>Control policial:</strong>
                    {{ $vehiculo->control->lugar ?? '—' }} ({{ $vehiculo->control->fecha }})
                </p>

            </div>
        </div>

        {{-- NOVEDADES --}}
        <div class="shadow rounded-xl p-6 border"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-xl font-semibold mb-4">Novedades Registradas</h3>

            @forelse($vehiculo->novedades as $n)
                <div class="border-b py-3" style="border-color: var(--border);">
                    <p class="font-semibold">{{ $n->tipo_novedad }}</p>
                    <p class="text-sm">{{ $n->observaciones }}</p>
                </div>
            @empty
                <p class="text-sm" style="color: var(--muted-foreground);">
                    No se registraron novedades.
                </p>
            @endforelse

        </div>
    </div>
</x-app-layout>
