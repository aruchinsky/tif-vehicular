<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Tus Operativos Asignados
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-4">

        @if ($controles->isEmpty())
            <div class="card p-10 text-center">
                <p class="text-xl font-semibold">No tenés operativos asignados.</p>
                <p class="mt-2" style="color: var(--muted-foreground)">
                    Si creés que es un error, contactá a tu administrador.
                </p>
            </div>

        @else

            <h3 class="text-3xl font-bold mb-6" style="color: var(--foreground)">
                Hola, {{ $personal->nombre_apellido }}
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                @foreach ($controles as $control)
                    <div class="card rounded-xl shadow-lg border p-6 hover:shadow-2xl transition">

                        <h4 class="text-lg font-bold mb-3">Operativo del {{ $control->fecha }}</h4>

                        <div class="rounded-lg p-4 mb-4"
                             style="background: var(--accent); color: var(--accent-foreground)">
                            <p class="uppercase font-bold text-sm">Ruta asignada</p>
                            <p class="text-2xl font-extrabold mt-1">
                                {{ $control->ruta ?? 'Sin ruta' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
                            <p><strong>Móvil:</strong> {{ $control->movil_asignado ?? '—' }}</p>
                            <p><strong>Inicio:</strong> {{ $control->hora_inicio }}</p>
                            <p><strong>Fin:</strong> {{ $control->hora_fin }}</p>
                        </div>

                        <div class="mt-4 text-right">
                            <a href="{{ route('controles.show', $control->id) }}"
                               class="px-4 py-2 rounded text-white font-semibold shadow"
                               style="background: var(--primary)">
                                Abrir Operativo
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>
</x-app-layout>
