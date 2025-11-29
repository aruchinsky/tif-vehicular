<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Editar Personal: {{ $personal_control->nombre_apellido }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Validaciones --}}
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg border border-red-400 bg-red-100 text-red-700">
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-lg rounded-xl border p-6 space-y-8">

            <form action="{{ route('personalcontrol.update', $personal_control->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ===================== --}}
                {{--   DATOS PERSONALES    --}}
                {{-- ===================== --}}
                <h3 class="text-lg font-semibold" style="color: var(--foreground)">Datos Personales</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Nombre y Apellido</label>
                        <input type="text" name="nombre_apellido"
                               value="{{ old('nombre_apellido', $personal_control->nombre_apellido) }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Legajo --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Legajo</label>
                        <input type="text" name="lejago_personal"
                               value="{{ old('lejago_personal', $personal_control->lejago_personal) }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- DNI --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">DNI</label>
                        <input type="text" name="dni"
                               value="{{ old('dni', $personal_control->dni) }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Jerarquía --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Jerarquía</label>
                        <input type="text" name="jerarquia"
                               value="{{ old('jerarquia', $personal_control->jerarquia) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                {{-- ===================== --}}
                {{--   CARGO Y ROL USER     --}}
                {{-- ===================== --}}
                <h3 class="text-lg font-semibold pt-3" style="color: var(--foreground)">Cargo y Acceso</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Cargo Policial --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Cargo Policial</label>
                        <select name="cargo_id"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            <option value="">Seleccione cargo</option>
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}"
                                    {{ old('cargo_id', $personal_control->cargo_id) == $cargo->id ? 'selected' : '' }}>
                                    {{ $cargo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Rol del usuario --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Rol del Usuario</label>
                        <select name="rol_id"
                                class="w-full px-4 py-3 rounded-lg border"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            <option value="">Seleccione</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}"
                                    {{ old('rol_id', $personal_control->usuario->role_id ?? '') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Móvil --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Móvil</label>
                        <input type="text" name="movil"
                               value="{{ old('movil', $personal_control->movil) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                {{-- ===================== --}}
                {{--   FECHAS Y LUGAR      --}}
                {{-- ===================== --}}
                <h3 class="text-lg font-semibold pt-3" style="color: var(--foreground)">Datos del Servicio</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Fecha --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Fecha del Control</label>
                        <input type="date" name="fecha_control"
                               value="{{ old('fecha_control', $personal_control->fecha_control) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Hora Inicio --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Hora Inicio</label>
                        <input type="time" name="hora_inicio"
                               value="{{ old('hora_inicio', $personal_control->hora_inicio) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Hora Fin --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Hora Fin</label>
                        <input type="time" name="hora_fin"
                               value="{{ old('hora_fin', $personal_control->hora_fin) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Lugar --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Lugar</label>
                        <input type="text" name="lugar"
                               value="{{ old('lugar', $personal_control->lugar) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Ruta --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Ruta / Camino</label>
                        <input type="text" name="ruta"
                               value="{{ old('ruta', $personal_control->ruta) }}"
                               class="w-full px-4 py-3 rounded-lg border"
                               style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-6">
                    <a href="{{ route('personalcontrol.index') }}"
                       class="px-5 py-3 rounded-lg"
                       style="background: var(--muted); color: var(--muted-foreground)">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Guardar Cambios
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
