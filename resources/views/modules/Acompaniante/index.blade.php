<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Gestión de Acompañantes
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Mensaje --}}
        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg border border-green-400 bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Crear --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('acompaniante.create') }}"
               class="px-5 py-3 rounded-lg font-semibold transition"
               style="background: var(--primary); color: var(--primary-foreground)">
                + Nuevo Acompañante
            </a>
        </div>

        {{-- Tabla --}}
        <div class="card shadow-lg border rounded-xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead style="background: var(--muted)">
                        <tr>
                            @foreach(['ID','DNI','Nombre','Domicilio','Tipo','Conductor','Acciones'] as $th)
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                    style="color: var(--muted-foreground)">
                                    {{ $th }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($acompañantes as $acompaniante)
                            <tr class="border-b" style="border-color: var(--border)">
                                <td class="px-6 py-4" style="color: var(--foreground)">{{ $acompaniante->id }}</td>
                                <td class="px-6 py-4">{{ $acompaniante->dni_acompaniante }}</td>
                                <td class="px-6 py-4">{{ $acompaniante->nombre_apellido }}</td>
                                <td class="px-6 py-4">{{ $acompaniante->domicilio }}</td>
                                <td class="px-6 py-4">{{ $acompaniante->tipo_acompaniante ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    {{ $acompaniante->conductor->nombre_apellido ?? '—' }}
                                </td>


                                <td class="px-6 py-4 flex gap-3">
                                    <a href="{{ route('acompaniante.show', $acompaniante->id) }}"
                                       style="color: var(--primary)" class="hover:opacity-70">Ver</a>

                                    <a href="{{ route('acompaniante.edit', $acompaniante->id) }}"
                                       style="color: var(--accent)" class="hover:opacity-70">Editar</a>

                                    <form action="{{ route('acompaniante.destroy', $acompaniante->id) }}"
                                          method="POST" onsubmit="return confirm('¿Eliminar acompañante?')">
                                        @csrf
                                        @method('DELETE')
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
