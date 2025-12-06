<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Gestión de Usuarios
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-lg border bg-emerald-50 text-emerald-800 text-sm"
                 style="border-color:#22c55e;">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center">
            <p class="text-sm" style="color: var(--muted-foreground);">
                Listado de usuarios con acceso al sistema.
            </p>

            <a href="{{ route('usuarios.create') }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                + Nuevo Usuario
            </a>
        </div>

        <div class="shadow rounded-xl border overflow-hidden"
             style="background: var(--card); border-color: var(--border);">

            <table class="w-full text-sm">
                <thead class="border-b" style="border-color: var(--border);">
                    <tr class="text-left">
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3">Personal asociado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $user)
                        @php
                            $rol = $user->roles->first()?->name ?? '—';
                        @endphp
                        <tr class="border-t hover:bg-[var(--muted)] transition"
                            style="border-color: var(--border);">
                            <td class="px-4 py-2">
                                {{ $user->name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full bg-[var(--muted)]">
                                    {{ $rol }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                {{ $user->personal?->nombre_apellido ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('usuarios.show', $user) }}"
                                   class="text-xs px-3 py-1 rounded bg-[var(--muted)]">
                                    Ver
                                </a>
                                <a href="{{ route('usuarios.edit', $user) }}"
                                   class="text-xs px-3 py-1 rounded"
                                   style="background: var(--primary); color: var(--primary-foreground);">
                                    Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $user) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs px-3 py-1 rounded bg-red-600 text-white">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-sm"
                                style="color: var(--muted-foreground);">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t" style="border-color: var(--border);">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
