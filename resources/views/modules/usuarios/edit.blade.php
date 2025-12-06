<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Editar usuario
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

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST"
              class="space-y-8">
            @csrf
            @method('PUT')

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
                        <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Nueva contraseña (opcional)
                        </label>
                        <input type="password" name="password"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Confirmar nueva contraseña
                        </label>
                        <input type="password" name="password_confirmation"
                               class="w-full rounded-lg border px-3 py-2 text-sm"
                               style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                    </div>

                    @php
                        $rolActual = $usuario->roles->first()?->name;
                    @endphp

                    <div>
                        <label class="text-sm font-medium block mb-1">
                            Rol del sistema
                        </label>
                        <select name="rol"
                                class="w-full rounded-lg border px-3 py-2 text-sm"
                                style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}"
                                    {{ old('rol', $rolActual) === $rol->name ? 'selected' : '' }}>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- BLOQUE PERSONAL --}}
            <div class="shadow rounded-xl p-6 border"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-lg font-semibold mb-4" style="color: var(--foreground);">
                    Personal policial vinculado
                </h3>

                @php
                    $tienePersonal = !is_null($usuario->personal);
                @endphp

                @if($rolActual === 'SUPERUSUARIO')
                    <p class="text-sm" style="color: var(--muted-foreground);">
                        Actualmente este usuario es SUPERUSUARIO.  
                        No requiere un registro en Personal; si tenía alguno asociado se desvinculará al guardar.
                    </p>
                @else

                    @if($tienePersonal)
                        <p class="text-xs mb-4" style="color: var(--muted-foreground);">
                            Este usuario ya tiene personal asociado. Podés actualizar los datos.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Nombre y apellido
                                </label>
                                <input type="text" name="nombre_apellido"
                                       value="{{ old('nombre_apellido', $usuario->personal->nombre_apellido) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    DNI
                                </label>
                                <input type="text" name="dni"
                                       value="{{ old('dni', $usuario->personal->dni) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Legajo
                                </label>
                                <input type="text" name="legajo"
                                       value="{{ old('legajo', $usuario->personal->legajo) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Jerarquía
                                </label>
                                <input type="text" name="jerarquia"
                                       value="{{ old('jerarquia', $usuario->personal->jerarquia) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Móvil
                                </label>
                                <input type="text" name="movil"
                                       value="{{ old('movil', $usuario->personal->movil) }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                        </div>

                    @else
                        <p class="text-xs mb-4" style="color: var(--muted-foreground);">
                            Este usuario no tiene personal asociado aún.  
                            Podés vincular uno existente o crear un nuevo registro.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                            <div class="flex items-center gap-2">
                                <input type="radio" id="modo_ninguno" name="modo_personal" value="ninguno"
                                       {{ old('modo_personal', 'ninguno') === 'ninguno' ? 'checked' : '' }}>
                                <label for="modo_ninguno" class="text-sm">
                                    No asociar todavía
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

                        {{-- EXISTENTE --}}
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

                        {{-- NUEVO --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Nombre y apellido
                                </label>
                                <input type="text" name="nombre_apellido"
                                       value="{{ old('nombre_apellido') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    DNI
                                </label>
                                <input type="text" name="dni"
                                       value="{{ old('dni') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Legajo
                                </label>
                                <input type="text" name="legajo"
                                       value="{{ old('legajo') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Jerarquía
                                </label>
                                <input type="text" name="jerarquia"
                                       value="{{ old('jerarquia') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                            <div>
                                <label class="text-sm font-medium block mb-1">
                                    Móvil
                                </label>
                                <input type="text" name="movil"
                                       value="{{ old('movil') }}"
                                       class="w-full rounded-lg border px-3 py-2 text-sm"
                                       style="background: var(--background); border-color: var(--border); color: var(--foreground);">
                            </div>

                        </div>

                    @endif

                @endif
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
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
