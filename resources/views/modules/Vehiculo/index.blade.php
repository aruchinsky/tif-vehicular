<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Vehículos Requisados
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-50 text-emerald-800 text-sm"
                 style="border-color:#22c55e;">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-sm" style="color: var(--muted-foreground);">
            Listado de todos los vehículos registrados en controles policiales.
        </p>

        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Dominio</th>
                        <th class="px-4 py-3">Modelo</th>
                        <th class="px-4 py-3">Conductor</th>
                        <th class="px-4 py-3">Control</th>
                        <th class="px-4 py-3">Operador</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($vehiculos as $v)
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">
                            
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($v->fecha_hora_control)->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-4 py-2 font-semibold">
                                {{ $v->dominio }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $v->marca_modelo }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $v->conductor->nombre_apellido ?? '—' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $v->control->lugar ?? '—' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $v->operador->nombre_apellido ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-right">

                                <div class="flex justify-end items-center gap-3">

                                    {{-- VER --}}
                                    <a href="{{ route('vehiculo.show', $v) }}"
                                    class="p-2 rounded hover:bg-[var(--muted)] transition"
                                    title="Ver vehículo">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-5 h-5"
                                            fill="none" viewBox="0 0 24 24" 
                                            stroke="currentColor" stroke-width="1.8"
                                            style="color: var(--foreground);">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 
                                                5c4.477 0 8.268 2.943 9.542 7-1.274 
                                                4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 
                                                016 0z" />
                                        </svg>
                                    </a>

                                    {{-- EDITAR --}}
                                    <a href="{{ route('vehiculo.edit', $v) }}"
                                    class="p-2 rounded hover:bg-[var(--muted)] transition"
                                    title="Editar vehículo">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.8"
                                            style="color: var(--primary);">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5h-6a2 2 0 00-2 
                                                2v12a2 2 0 002 2h12a2 2 0 
                                                002-2v-6m-5-9l5 5m-5-5l-7 
                                                7v0a4 4 0 005 5l7-7m-5-5l5 
                                                5" />
                                        </svg>
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <form action="{{ route('vehiculo.destroy', $v) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar vehículo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded hover:bg-red-100 transition"
                                                title="Eliminar vehículo">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5"
                                                fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8"
                                                style="color: #dc2626;">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 7h12M9 7V4h6v3m1 
                                                    0v10a2 2 0 01-2 2H9a2 2 0 
                                                    01-2-2V7h10z" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-sm"
                                style="color: var(--muted-foreground);">
                                No hay vehículos registrados.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
