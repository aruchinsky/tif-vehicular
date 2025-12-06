<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Detalle de usuario
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 space-y-6">

        <div class="shadow rounded-xl p-6 border"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground);">
                Datos de acceso
            </h3>

            <p class="text-sm"><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p class="text-sm"><strong>Email:</strong> {{ $usuario->email }}</p>
            <p class="text-sm">
                <strong>Rol:</strong> {{ $usuario->roles->first()?->name ?? '—' }}
            </p>
            <p class="text-sm">
                <strong>Creado:</strong> {{ $usuario->created_at?->format('d/m/Y H:i') }}
            </p>
        </div>

        <div class="shadow rounded-xl p-6 border"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground);">
                Personal vinculado
            </h3>

            @if($usuario->personal)
                <p class="text-sm"><strong>Nombre:</strong> {{ $usuario->personal->nombre_apellido }}</p>
                <p class="text-sm"><strong>DNI:</strong> {{ $usuario->personal->dni }}</p>
                <p class="text-sm"><strong>Legajo:</strong> {{ $usuario->personal->legajo }}</p>
                <p class="text-sm"><strong>Jerarquía:</strong> {{ $usuario->personal->jerarquia ?? '—' }}</p>
                <p class="text-sm"><strong>Móvil:</strong> {{ $usuario->personal->movil ?? '—' }}</p>
            @else
                <p class="text-sm" style="color: var(--muted-foreground);">
                    No hay personal asociado a este usuario.
                </p>
            @endif
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('usuarios.index') }}"
               class="px-4 py-2 rounded-lg text-sm"
               style="background: var(--muted); color: var(--foreground);">
                Volver
            </a>

            <a href="{{ route('usuarios.edit', $usuario) }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
               style="background: var(--primary); color: var(--primary-foreground);">
                Editar usuario
            </a>
        </div>
    </div>
</x-app-layout>
