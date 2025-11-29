<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Registrar Personal de Control
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

            {{-- ======================= --}}
            {{--   SECCIÓN USUARIO       --}}
            {{-- ======================= --}}
            <fieldset class="border rounded-xl p-6" style="border-color: var(--border)">
                <legend class="px-3 text-lg font-semibold" style="color: var(--foreground)">Asociar Usuario</legend>

                <div class="space-y-4">

                    {{-- Radios --}}
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="user_option" value="new" checked
                                class="h-4 w-4"
                                onchange="toggleUserFields(this.value)">
                            <span style="color: var(--foreground)">Crear nuevo usuario</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="user_option" value="existing"
                                class="h-4 w-4"
                                onchange="toggleUserFields(this.value)">
                            <span style="color: var(--foreground)">Asociar usuario existente</span>
                        </label>
                    </div>

                    {{-- Nuevo usuario --}}
                    <div id="new_user_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-semibold" style="color: var(--foreground)">Nombre de Usuario</label>
                            <input type="text" name="user_name"
                                class="w-full px-4 py-3 rounded-lg border"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        </div>

                        <div>
                            <label class="font-semibold" style="color: var(--foreground)">Email</label>
                            <input type="email" name="user_email"
                                class="w-full px-4 py-3 rounded-lg border"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        </div>

                        <div>
                            <label class="font-semibold" style="color: var(--foreground)">Contraseña</label>
                            <input type="password" name="user_password"
                                class="w-full px-4 py-3 rounded-lg border"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        </div>

                        <div>
                            <label class="font-semibold" style="color: var(--foreground)">Rol del Usuario</label>
                            <select name="rol_id"
                                class="w-full px-4 py-3 rounded-lg border"
                                style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                                <option value="">Seleccione rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Usuario existente --}}
                    <div id="existing_user_fields" class="hidden">
                        <label class="font-semibold" style="color: var(--foreground)">Seleccionar Usuario Existente</label>
                        <select name="existing_user_id" disabled
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            <option value="">Seleccione usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </fieldset>


            {{-- ======================= --}}
            {{--   DATOS PERSONALES      --}}
            {{-- ======================= --}}
            <form action="{{ route('personalcontrol.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Nombre y Apellido</label>
                        <input type="text" name="nombre_apellido" required
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Legajo --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Legajo</label>
                        <input type="text" name="lejago_personal" required
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- DNI --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">DNI</label>
                        <input type="number" name="dni" required
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Jerarquía --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Jerarquía</label>
                        <input type="text" name="jerarquia"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Cargo Policial --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Cargo Policial</label>
                        <select name="cargo_id"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                            <option value="">Seleccione cargo</option>
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Móvil --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Móvil</label>
                        <input type="text" name="movil"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Lugar --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Lugar del Control</label>
                        <input type="text" name="lugar"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Ruta --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Ruta</label>
                        <input type="text" name="ruta"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Fecha</label>
                        <input type="date" name="fecha_control"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Inicio --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Hora Inicio</label>
                        <input type="time" name="hora_inicio"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                    {{-- Fin --}}
                    <div>
                        <label class="font-semibold" style="color: var(--foreground)">Hora Fin</label>
                        <input type="time" name="hora_fin"
                            class="w-full px-4 py-3 rounded-lg border"
                            style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('personalcontrol.index') }}"
                        class="px-5 py-3 rounded-lg"
                        style="background: var(--muted); color: var(--muted-foreground)">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-lg font-semibold"
                        style="background: var(--primary); color: var(--primary-foreground)">
                        Guardar Personal
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function toggleUserFields(opt) {
            const newUser = document.getElementById("new_user_fields");
            const existing = document.getElementById("existing_user_fields");
            const existingSelect = existing.querySelector("select");

            if (opt === "new") {
                newUser.classList.remove("hidden");
                existing.classList.add("hidden");
                existingSelect.disabled = true;
            } else {
                newUser.classList.add("hidden");
                existing.classList.remove("hidden");
                existingSelect.disabled = false;
            }
        }
    </script>
</x-app-layout>
