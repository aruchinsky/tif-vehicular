<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold" style="color: var(--foreground)">
            Editar Vehículo: {{ $vehiculo->marca_modelo }}
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

        <form action="{{ route('vehiculo.update', $vehiculo->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Personal de Control</label>
                    <select name="personal_control_id"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        @foreach($personalControls as $p)
                            <option value="{{ $p->id }}" {{ $vehiculo->personal_control_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Conductor</label>
                    <select name="conductor_id"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                        @foreach($conductores as $c)
                            <option value="{{ $c->id }}" {{ $vehiculo->conductor_id == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Marca / Modelo</label>
                    <input type="text" name="marca_modelo" value="{{ $vehiculo->marca_modelo }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Dominio</label>
                    <input type="text" name="dominio" value="{{ $vehiculo->dominio }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Color</label>
                    <input type="text" name="color" value="{{ $vehiculo->color }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold" style="color: var(--foreground)">Fecha y Hora</label>
                    <input type="datetime-local" name="fecha_hora_control"
                        value="{{ date('Y-m-d\TH:i', strtotime($vehiculo->fecha_hora_control)) }}"
                        class="w-full px-4 py-3 rounded-lg border"
                        style="background: var(--card); border-color: var(--input); color: var(--foreground)">
                </div>

            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('vehiculo.index') }}"
                    class="px-5 py-3 rounded-lg"
                    style="background: var(--muted); color: var(--muted-foreground)">
                    Cancelar
                </a>

                <button class="px-5 py-3 rounded-lg font-semibold"
                    style="background: var(--primary); color: var(--primary-foreground)">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
