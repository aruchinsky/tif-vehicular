<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Personal de Control
    </x-slot>

```
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
    <form action="{{ route('personalcontrol.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <fieldset class="border p-4 rounded-md space-y-4">
            <legend class="text-lg font-semibold px-2">Asociar o Crear Usuario</legend>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Opción de Usuario
                </label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="user_option" value="new" id="option_new_user" checked 
                                    class="form-radio text-indigo-600 dark:bg-gray-700" 
                                    onchange="toggleUserFields(this.value)">
                        <span class="ml-2">Crear Nuevo Usuario</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="user_option" value="existing" id="option_existing_user"
                                    class="form-radio text-indigo-600 dark:bg-gray-700"
                                    onchange="toggleUserFields(this.value)">
                        <span class="ml-2">Usar Usuario Existente</span>
                    </label>
                </div>
                @error('user_option') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div id="new_user_fields" class="space-y-4">
                <div>
                    <label for="user_name">Nombre de Usuario</label>
                    <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    @error('user_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" name="user_email" value="{{ old('user_email') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    @error('user_email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="user_password">Contraseña</label>
                    <input type="password" id="user_password" name="user_password" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    @error('user_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Rol de Acceso (Campo role_id de User) --}}
                <div>
                    <label for="rol_id">Rol de Acceso del Usuario</label>
                    <select id="rol_id" name="rol_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                        <option value="">Seleccione un Rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                    @error('rol_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div id="existing_user_fields" style="display:none;">
                <div>
                    <label for="existing_user_id">Seleccionar Usuario Existente</label>
                    <select id="existing_user_id" name="existing_user_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required disabled>
                        <option value="">Seleccione un Usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('existing_user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('existing_user_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- El resto de tu formulario se mantiene igual --}}
        {{-- Nombre y Apellido --}}
        <div>
            <label for="nombre_apellido">Nombre y Apellido</label>
            <input type="text" id="nombre_apellido" name="nombre_apellido" value="{{ old('nombre_apellido') }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('nombre_apellido') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        {{-- Legajo --}}
        <div>
            <label for="lejago_personal">Legajo</label>
            <input type="text" id="lejago_personal" name="lejago_personal" value="{{ old('lejago_personal') }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('lejago_personal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- DNI --}}
        <div>
            <label for="dni">DNI</label>
            <input type="number" id="dni" name="dni" value="{{ old('dni') }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('dni') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Jerarquía --}}
        <div>
            <label for="jerarquia">Jerarquía</label>
            <input type="text" id="jerarquia" name="jerarquia" value="{{ old('jerarquia') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('jerarquia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Rol en Control (Campo ENUM de PersonalControl) --}}
        <div> 
            <label for="rol_en_control">Rol en el Control</label>
            <select id="rol_en_control" name="rol_en_control" 
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Seleccione un Rol del Control</option>
                    @foreach ($enumValues as $value)
                        <option value="{{ $value }}" {{ old('rol_en_control') == $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
            </select>
            @error('rol_en_control') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="movil" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Móvil Asignado
            </label>
                    <input type="text" id="movil" name="movil"
                        value="{{ old('movil', $personal_control->movil ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                        dark:bg-gray-700 dark:text-white">
                        @error('movil')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
        </div>


        {{-- Fecha, Hora Inicio, Hora Fin, Lugar, Ruta --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="fecha_control">Fecha del Control</label>
                <input type="date" id="fecha_control" name="fecha_control" value="{{ old('fecha_control') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                @error('fecha_control') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="hora_inicio">Hora de Inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                @error('hora_inicio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="hora_fin">Hora de Fin</label>
                <input type="time" id="hora_fin" name="hora_fin" value="{{ old('hora_fin') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                @error('hora_fin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="lugar">Lugar</label>
                <input type="text" id="lugar" name="lugar" value="{{ old('lugar') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                @error('lugar') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="ruta">Ruta / Camino</label>
                <input type="text" id="ruta" name="ruta" value="{{ old('ruta') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                @error('ruta') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('personalcontrol.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar Personal</button>
        </div>
    </form>
</div>

<script>
    function toggleUserFields(option) {
        const newFields = document.getElementById('new_user_fields');
        const existingFields = document.getElementById('existing_user_fields');
        
        // Campos de nuevo usuario
        const userNameInput = document.getElementById('user_name');
        const userEmailInput = document.getElementById('user_email');
        const userPasswordInput = document.getElementById('user_password');
        const rolSelect = document.getElementById('rol_id');
        
        // Campo de usuario existente
        const existingUserIdSelect = document.getElementById('existing_user_id');

        if (option === 'new') {
            newFields.style.display = 'block';
            existingFields.style.display = 'none';

            userNameInput.removeAttribute('disabled');
            userEmailInput.removeAttribute('disabled');
            userPasswordInput.removeAttribute('disabled');
            rolSelect.removeAttribute('disabled');

            userNameInput.setAttribute('required', 'required');
            userEmailInput.setAttribute('required', 'required');
            userPasswordInput.setAttribute('required', 'required');
            rolSelect.setAttribute('required', 'required');

            existingUserIdSelect.setAttribute('disabled', 'disabled');
            existingUserIdSelect.removeAttribute('required');
            existingUserIdSelect.value = "";

        } else if (option === 'existing') {
            newFields.style.display = 'none';
            existingFields.style.display = 'block';

            userNameInput.setAttribute('disabled', 'disabled');
            userEmailInput.setAttribute('disabled', 'disabled');
            userPasswordInput.setAttribute('disabled', 'disabled');
            rolSelect.setAttribute('disabled', 'disabled');

            userNameInput.removeAttribute('required');
            userEmailInput.removeAttribute('required');
            userPasswordInput.removeAttribute('required');
            rolSelect.removeAttribute('required');

            userNameInput.value = "";
            userEmailInput.value = "";
            userPasswordInput.value = "";
            rolSelect.value = "";

            existingUserIdSelect.removeAttribute('disabled');
            existingUserIdSelect.setAttribute('required', 'required');
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        const selectedOption = document.querySelector('input[name="user_option"]:checked') 
            ? document.querySelector('input[name="user_option"]:checked').value 
            : 'new'; 
        toggleUserFields(selectedOption);
    });
</script>
```

</x-app-layout>
