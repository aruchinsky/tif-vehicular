<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Crear nuevo usuario
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 space-y-6">

        @if ($errors->any())
            <div class="p-4 border border-red-300 bg-red-50 text-red-800 rounded-lg text-sm">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('usuarios.store') }}" method="POST"
              class="space-y-8">
            @csrf

            {{-- DATOS DE ACCESO --}}
            <div class="shadow rounded-xl p-6 border"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground);">
                    Datos de acceso
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Nombre de usuario
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Contraseña
                        </label>
                        <input type="password" name="password"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Confirmar contraseña
                        </label>
                        <input type="password" name="password_confirmation"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Rol del sistema
                        </label>
                        <select name="rol"
                                class="w-full rounded-lg border px-3 py-2 text-sm"
                                style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            <option value="">-- Seleccionar --</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}" {{ old('rol') === $rol->name ? 'selected' : '' }}>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs mt-1" style="color: var(--muted-foreground);">
                            SUPERUSUARIO no requiere personal. ADMINISTRADOR y OPERADOR sí.
                        </p>
                    </div>

                </div>
            </div>

            {{-- BLOQUE PERSONAL / POLICÍA --}}
            <div class="shadow rounded-xl p-6 border"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground);">
                    Personal policial vinculado
                </h3>

                <p class="text-xs mb-4" style="color: var(--muted-foreground);">
                    Para ADMINISTRADOR u OPERADOR es obligatorio asociar un personal.  
                    Elegí si vas a usar un personal existente o crear uno nuevo.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                    <div class="flex items-center gap-2">
                        <input type="radio" id="modo_ninguno" name="modo_personal" value="ninguno"
                               {{ old('modo_personal', 'ninguno') === 'ninguno' ? 'checked' : '' }}>
                        <label for="modo_ninguno" class="text-sm">
                            Sin personal (solo para SUPERUSUARIO)
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="radio" id="modo_existente" name="modo_personal" value="existente"
                               {{ old('modo_personal') === 'existente' ? 'checked' : '' }}>
                        <label for="modo_existente" class="text-sm">
                            Asociar personal existente
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="radio" id="modo_nuevo" name="modo_personal" value="nuevo"
                               {{ old('modo_personal') === 'nuevo' ? 'checked' : '' }}>
                        <label for="modo_nuevo" class="text-sm">
                            Crear nuevo personal
                        </label>
                    </div>
                </div>

                {{-- PERSONAL EXISTENTE --}}
                <div class="mb-6">
                    <label class="text-sm font-medium block mb-1">
                        Personal existente (sin usuario)
                    </label>
                    <select name="personal_id"
                            class="w-full rounded-lg border px-3 py-2 text-sm"
                            style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                        <option value="">-- Seleccionar personal --</option>
                        @foreach($personalSinUsuario as $p)
                            <option value="{{ $p->id }}" {{ old('personal_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nombre_apellido }} — DNI: {{ $p->dni }} — Legajo: {{ $p->legajo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NUEVO PERSONAL --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Nombre y apellido
                        </label>
                        <input type="text" name="nombre_apellido" value="{{ old('nombre_apellido') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            DNI
                        </label>
                        <input type="text" name="dni" value="{{ old('dni') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Legajo
                        </label>
                        <input type="text" name="legajo" value="{{ old('legajo') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Jerarquía
                        </label>
                        <input type="text" name="jerarquia" value="{{ old('jerarquia') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Móvil
                        </label>
                        <input type="text" name="movil" value="{{ old('movil') }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                </div>

            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('usuarios.index') }}"
                   class="px-4 py-2 rounded-lg text-sm"
                   style="background: var(--muted); color: var(--foreground);">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-semibold shadow"
                        style="background: var(--primary); color: var(--primary-foreground);">
                    Guardar usuario
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
