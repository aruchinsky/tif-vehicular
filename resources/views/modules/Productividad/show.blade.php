<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Detalle de Productividad del Día
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="card border shadow-lg rounded-xl p-6 space-y-8">

            {{-- ENCABEZADO --}}
            <div>
                <p class="text-sm" style="color: var(--muted-foreground)">Fecha</p>
                <p class="text-2xl font-bold" style="color: var(--foreground)">
                    {{ \Carbon\Carbon::parse($productividad->fecha)->format('d/m/Y') }}
                </p>

                <p class="mt-2 text-sm" style="color: var(--muted-foreground)">Personal Responsable</p>
                <p class="font-semibold" style="color: var(--foreground)">
                    {{ $productividad->personalControl->nombre_apellido ?? 'No asignado' }}
                </p>
            </div>

            <hr style="border-color: var(--border)">

            {{-- CARTAS DE TOTALES --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <div class="rounded-xl p-5 text-center shadow-md"
                     style="background: var(--accent); color: var(--accent-foreground)">
                    <p class="text-sm font-semibold opacity-75">Conductores</p>
                    <p class="text-3xl font-bold">{{ $productividad->total_conductor }}</p>
                </div>

                <div class="rounded-xl p-5 text-center shadow-md"
                     style="background: var(--primary); color: var(--primary-foreground)">
                    <p class="text-sm font-semibold opacity-75">Vehículos</p>
                    <p class="text-3xl font-bold">{{ $productividad->total_vehiculos }}</p>
                </div>

                <div class="rounded-xl p-5 text-center shadow-md"
                     style="background: var(--secondary); color: var(--secondary-foreground)">
                    <p class="text-sm font-semibold opacity-75">Acompañantes</p>
                    <p class="text-3xl font-bold">{{ $productividad->total_acompanante }}</p>
                </div>

            </div>

            {{-- TOTAL PERSONAS --}}
            <div class="rounded-xl p-5 text-center shadow-lg mt-4"
                 style="background: var(--card); color: var(--foreground)">
                <p class="text-sm opacity-75">Total Personas Registradas</p>
                <p class="text-3xl font-extrabold">
                    {{ $productividad->total_conductor + $productividad->total_acompanante }}
                </p>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('productividad.index') }}"
                   class="px-4 py-2 rounded-lg font-semibold"
                   style="background: var(--muted); color: var(--muted-foreground)">
                    Volver
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
