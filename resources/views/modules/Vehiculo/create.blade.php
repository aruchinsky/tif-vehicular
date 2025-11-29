<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Registrar Nuevo Vehículo
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-8 rounded-xl shadow-lg border"
         style="background: var(--card); border-color: var(--border)">

        {{-- VALIDACIONES --}}
        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg border border-red-400 bg-red-100 text-red-700">
                <strong class="font-semibold">Errores detectados:</strong>
                <ul class="mt-2 ml-5 list-disc">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehiculo.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- PERSONAL --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Personal de Control</label>
                    <select name="personal_control_id"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        <option value="">Seleccione</option>
                        @foreach($personalControls as $p)
                            <option value="{{ $p->id }}" {{ old('personal_control_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- CONDUCTOR --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Conductor</label>
                    <select name="conductor_id"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        <option value="">Seleccione</option>
                        @foreach($conductores as $c)
                            <option value="{{ $c->id }}" {{ old('conductor_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MARCA --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Marca / Modelo</label>
                    <input type="text" name="marca_modelo" value="{{ old('marca_modelo') }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                {{-- DOMINIO --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Dominio</label>
                    <input type="text" name="dominio" value="{{ old('dominio') }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                {{-- COLOR --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                {{-- FECHA --}}
                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Fecha y Hora del Control</label>
                    <input type="datetime-local" name="fecha_hora_control" value="{{ old('fecha_hora_control') }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

            </div>

            <div class="flex justify-end gap-4">
                <a href="javascript:window.history.back()"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancelar
                </a>


                <button
                    class="px-5 py-3 rounded-lg font-semibold"
                    style="background: var(--primary); color: var(--primary-foreground)">
                    Guardar Vehículo
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
