<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Gestión de Personal de Control
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Mensaje --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg border border-green-400 bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('personalcontrol.create') }}"
               class="px-5 py-3 rounded-lg font-semibold transition"
               style="background: var(--primary); color: var(--primary-foreground)">
                + Nuevo Personal
            </a>
        </div>

        {{-- Tabla --}}
        <div class="card shadow-lg rounded-xl overflow-hidden border">

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead style="background: var(--muted)">
                        <tr>
                            @foreach(['ID','Nombre','Legajo','DNI','Jerarquía','Cargo','Móvil','Fecha','Inicio','Fin','Acciones'] as $th)
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                    style="color: var(--muted-foreground)">
                                    {{ $th }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($personalControls as $p)
                        <tr class="border-b" style="border-color: var(--border)">
                            <td class="px-6 py-4">{{ $p->id }}</td>
                            <td class="px-6 py-4">{{ $p->nombre_apellido }}</td>
                            <td class="px-6 py-4">{{ $p->lejago_personal }}</td>
                            <td class="px-6 py-4">{{ $p->dni }}</td>
                            <td class="px-6 py-4">{{ $p->jerarquia }}</td>
                            <td class="px-6 py-4">{{ $p->cargo->nombre ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $p->movil }}</td>
                            <td class="px-6 py-4">{{ $p->fecha_control }}</td>
                            <td class="px-6 py-4">{{ $p->hora_inicio }}</td>
                            <td class="px-6 py-4">{{ $p->hora_fin }}</td>

                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('personalcontrol.show', $p->id) }}"
                                   style="color: var(--primary)" class="hover:opacity-70">Ver</a>
                                <a href="{{ route('personalcontrol.edit', $p->id) }}"
                                   style="color: var(--accent)" class="hover:opacity-70">Editar</a>

                                <form action="{{ route('personalcontrol.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar este registro?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="color: var(--destructive)"
                                            class="hover:opacity-70">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
