<x-app-layout>

    {{-- ========================================================= --}}
    {{-- 📌 HEADER DEL OPERATIVO --}}
    {{-- ========================================================= --}}
    <x-slot name="header">
        <div class="flex items-center gap-4">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-10 h-10 text-blue-600 dark:text-blue-400"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 5l9-3 9 3v6c0 5-3.5 9.74-9 11-5.5-1.26-9-6-9-11V5z"/>
            </svg>

            <div>
                <h1 class="text-3xl font-extrabold" style="color: var(--foreground);">
                    Operativo del {{ \Carbon\Carbon::parse($control->fecha)->format('d/m/Y') }}
                </h1>
                <p class="text-sm" style="color: var(--muted-foreground);">
                    Operador: <strong>{{ auth()->user()->name }}</strong>
                </p>
            </div>

        </div>
    </x-slot>



    <div class="max-w-7xl mx-auto px-4 space-y-10">

        {{-- ========================================================= --}}
        {{-- 🟦 TARJETA PRINCIPAL DE INFORMACIÓN --}}
        {{-- ========================================================= --}}
        <div class="p-8 rounded-2xl shadow border border-blue-500/30"
             style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color:white;">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div>
                    <p class="text-blue-200 text-xs uppercase">Lugar</p>
                    <p class="text-lg font-bold">{{ $control->lugar }}</p>
                </div>

                <div>
                    <p class="text-blue-200 text-xs uppercase">Ruta</p>
                    <p class="text-lg font-bold">{{ $control->ruta ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-blue-200 text-xs uppercase">Móvil</p>
                    <p class="text-lg font-bold">{{ $control->movil_asignado ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-blue-200 text-xs uppercase">Horario</p>
                    <p class="text-lg font-bold">
                        {{ \Carbon\Carbon::parse($control->hora_inicio)->format('H:i') }}
                        —
                        {{ \Carbon\Carbon::parse($control->hora_fin)->format('H:i') }}
                    </p>
                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- 🟦 BOTONES PRINCIPALES --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

            {{-- 🟦 Registrar Vehículo + Conductor --}}
            <button
                type="button"
                x-data
                @click="$dispatch('open-modal', 'modal-registrar-vehiculo')"
                class="p-5 rounded-xl shadow-lg text-center font-semibold transition hover:scale-105"
                style="background: var(--primary); color: var(--primary-foreground);">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-9 h-9 mx-auto mb-2 opacity-80"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                          d="M3 13l2-5h4l2 5m6 0h2.5a2.5 2.5 0 110 5H6a2.5 2.5 0 110-5H9"/>
                </svg>

                Registrar Vehículo + Conductor
            </button>

            {{-- 🟥 Registrar Novedad --}}
            <button
                type="button"
                x-data
                @click="$dispatch('open-modal', 'modal-registrar-novedad')"
                class="p-5 rounded-xl shadow-lg text-center font-semibold transition hover:scale-105"
                style="background:#dc2626; color:white;">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-9 h-9 mx-auto mb-2 opacity-80"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M10.29 3.86L1.82 19.14A1 1 0 002.76 21h18.48a1 1 0 00.94-1.86L13.71 3.86a1 1 0 00-1.42 0z" />
                </svg>

                Registrar Novedad
            </button>

        </div>



        {{-- ========================================================= --}}
        {{-- 🟦 LISTADO DE VEHÍCULOS --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6 border"
             style="background-color: var(--card); border-color: var(--border);">

            <h2 class="text-xl font-bold mb-4" style="color: var(--foreground);">
                Vehículos Requisados
            </h2>

            @forelse ($vehiculos as $v)
                <div class="border-b py-4" style="border-color: var(--border)">
                    <p class="font-semibold text-lg">
                        {{ $v->marca_modelo }} — {{ $v->dominio }}
                    </p>

                    <p class="text-sm" style="color: var(--muted-foreground)">
                        Color: <strong>{{ $v->color ?? '—' }}</strong><br>
                        Conductor: <strong>{{ $v->conductor->nombre_apellido }}</strong><br>
                        DNI: <strong>{{ $v->conductor->dni_conductor }}</strong><br>
                    </p>
                </div>
            @empty
                <p class="text-sm" style="color: var(--muted-foreground)">
                    No se han registrado vehículos aún.
                </p>
            @endforelse
        </div>



        {{-- ========================================================= --}}
        {{-- 🟦 LISTADO DE NOVEDADES --}}
        {{-- ========================================================= --}}
        <div class="shadow rounded-xl p-6 border"
             style="background-color: var(--card); border-color: var(--border);">

            <h2 class="text-xl font-bold mb-4" style="color: var(--foreground);">
                Novedades
            </h2>

            @forelse ($novedades as $n)
                <div class="border-b py-4">
                    <p class="font-semibold">
                        {{ $n->tipo_novedad }}
                        <span class="text-xs px-2 py-1 rounded bg-red-600 text-white">
                            {{ $n->aplica }}
                        </span>
                    </p>

                    <p class="text-sm" style="color: var(--muted-foreground)">
                        {{ $n->observaciones }}
                    </p>
                </div>
            @empty
                <p class="text-sm" style="color: var(--muted-foreground)">
                    No hay novedades registradas.
                </p>
            @endforelse

        </div>


        {{-- ========================================================= --}}
        {{-- 🟦 EXPORTAR PDF --}}
        {{-- ========================================================= --}}
        <div class="text-center py-8">
            <a href="{{ route('control.export.pdf', $control->id) }}"
               class="px-6 py-3 rounded-xl font-semibold shadow-lg text-white 
                      bg-blue-700 hover:bg-blue-800 transition text-lg">
                📄 Exportar Informe PDF
            </a>
        </div>

    </div>


{{-- ========================================================= --}}
{{-- 🟦 MODAL REGISTRAR VEHÍCULO + CONDUCTOR (ULTRA MODERNO) --}}
{{-- ========================================================= --}}
<x-modal-simple name="modal-registrar-vehiculo" maxWidth="2xl">

    <div x-data="modalVehiculoConductor()" class="p-6 space-y-6"
        style="background-color: var(--card); color: var(--card-foreground);">

        {{-- TÍTULO --}}
        <h2 class="text-2xl font-bold flex items-center gap-2">
            Registrar Vehículo Requisado
        </h2>

        <p class="text-sm" style="color: var(--muted-foreground)">
            Completá los datos del vehículo detenido y su conductor.
        </p>

        {{-- =============================== --}}
        {{-- NAV TABS --}}
        {{-- =============================== --}}
        <div class="flex gap-3 border-b pb-2" style="border-color: var(--border)">
            <button 
                @click="tab='vehiculo'"
                :class="tab==='vehiculo' 
                            ? 'font-bold text-blue-600 border-b-2 border-blue-600' 
                            : 'text-gray-500 hover:text-gray-800'"
                class="px-3 py-1 transition">
                Vehículo
            </button>

            <button 
                @click="tab='conductor'"
                :class="tab==='conductor' 
                            ? 'font-bold text-blue-600 border-b-2 border-blue-600'
                            : 'text-gray-500 hover:text-gray-800'"
                class="px-3 py-1 transition">
                Conductor
            </button>
        </div>

        <form method="POST" action="{{ route('control.vehiculo.store-operador') }}">
            @csrf
            <input type="hidden" name="control_id" value="{{ $control->id }}">
            <input type="hidden" name="operador_id" value="{{ auth()->user()->personal->id }}">

            {{-- ========================================================= --}}
            {{-- TAB 1 — VEHÍCULO --}}
            {{-- ========================================================= --}}
            <div x-show="tab === 'vehiculo'" x-transition class="space-y-4">

                <div>
                    <label class="font-semibold">Marca y Modelo *</label>
                    <input type="text" name="marca_modelo" required autocomplete="off"
                        class="w-full mt-1 p-2 rounded-lg border"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold">Dominio *</label>
                    <input type="text" name="dominio" required autocomplete="off"
                        class="w-full mt-1 p-2 rounded-lg border uppercase"
                        placeholder="ABC123 / AE123CD"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold">Color</label>
                    <input type="text" name="color" autocomplete="off"
                        class="w-full mt-1 p-2 rounded-lg border"
                        placeholder="Negro, Blanco, Rojo..."
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- TAB 2 — CONDUCTOR --}}
            {{-- ========================================================= --}}
            <div x-show="tab === 'conductor'" x-transition class="space-y-4">

                <div>
                    <label class="font-semibold">DNI *</label>
                    <input type="text" name="dni_conductor" required autocomplete="off"
                        class="w-full mt-1 p-2 rounded-lg border"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold">Nombre y Apellido *</label>
                    <input type="text" name="nombre_apellido" required autocomplete="off"
                        class="w-full mt-1 p-2 rounded-lg border"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold">Domicilio</label>
                    <input type="text" name="domicilio" autocomplete="off"
                        placeholder="Barrio — Calle — Nº"
                        class="w-full mt-1 p-2 rounded-lg border"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>

                <div>
                    <label class="font-semibold">Categoría de Carnet</label>
                    <select name="categoria_carnet"
                            class="w-full mt-1 p-2 rounded-lg border"
                            style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                        <option value="">— Seleccionar —</option>
                        <option>A</option>
                        <option>B1</option>
                        <option>B2</option>
                        <option>C</option>
                        <option>D1</option>
                        <option>D2</option>
                        <option>E1</option>
                        <option>E2</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Tipo de Conductor</label>
                    <select name="tipo_conductor"
                            class="w-full mt-1 p-2 rounded-lg border"
                            style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                        <option value="">— Seleccionar —</option>
                        <option>Particular</option>
                        <option>Profesional</option>
                        <option>Transporte Público</option>
                        <option>Taxi</option>
                        <option>Remís</option>
                        <option>Camión</option>
                        <option>Motomandado</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Destino</label>
                    <input type="text" name="destino" autocomplete="off"
                        placeholder="Hacia dónde se dirigía"
                        class="w-full mt-1 p-2 rounded-lg border"
                        style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- BOTONES --}}
            {{-- ========================================================= --}}
            <div class="flex justify-between mt-6">

                {{-- Botón Volver atrás/Lógica anterior --}}
                <button type="button"
                        @click="tab === 'conductor' ? tab='vehiculo' : null"
                        x-show="tab === 'conductor'"
                        class="px-4 py-2 rounded-lg font-semibold shadow
                            bg-gray-300 dark:bg-gray-700 dark:text-white">
                    ← Vehículo
                </button>

                <div class="flex gap-3 ml-auto">

                    {{-- CANCELAR --}}
                    <button type="button"
                            @click="$dispatch('close-modal', 'modal-registrar-vehiculo')"
                            class="px-4 py-2 rounded-lg font-semibold"
                            style="background: var(--muted); color: var(--foreground);">
                        Cancelar
                    </button>

                    {{-- SIGUIENTE / GUARDAR --}}
                    <template x-if="tab === 'vehiculo'">
                        <button type="button"
                                @click="tab='conductor'"
                                class="px-5 py-2 rounded-lg font-semibold shadow-lg
                                    bg-blue-600 text-white hover:bg-blue-700">
                            Siguiente →
                        </button>
                    </template>

                    <template x-if="tab === 'conductor'">
                        <button type="submit"
                                class="px-5 py-2 rounded-lg font-semibold shadow-lg
                                    bg-green-600 text-white hover:bg-green-700">
                            Registrar Vehículo
                        </button>
                    </template>

                </div>

            </div>

        </form>

    </div>

</x-modal-simple>

<x-modal-simple name="modal-registrar-novedad" maxWidth="lg">

    <div class="p-6 space-y-6"
        style="background-color: var(--card); color: var(--card-foreground);">

        <h2 class="text-2xl font-bold flex items-center gap-2">
            Registrar Novedad
        </h2>

        <p class="text-sm" style="color: var(--muted-foreground)">
            Ingresá una novedad detectada durante el control del vehículo.
        </p>

        <form method="POST" action="{{ route('control.novedades.store-operador') }}">
            @csrf

            <input type="hidden" name="control_id" value="{{ $control->id }}">

            {{-- SELECCIONAR VEHÍCULO --}}
            <div>
                <label class="font-semibold">Vehículo *</label>
                <select name="vehiculo_id" required
                    class="w-full mt-1 p-2 rounded-lg border"
                    style="background:var(--input); border-color:var(--border); color:var(--foreground)">
                    <option value="">— Seleccioná vehículo —</option>
                    @foreach ($vehiculos as $v)
                        <option value="{{ $v->id }}">
                            {{ $v->dominio }} — {{ $v->marca_modelo }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TIPO DE NOVEDAD --}}
            <div>
                <label class="font-semibold">Tipo de Novedad *</label>
                <select name="tipo_novedad" required
                    class="w-full mt-1 p-2 rounded-lg border"
                    style="background:var(--input); border-color:var(--border); color:var(--foreground);">
                    <option value="">— Seleccionar —</option>
                    <option>Documentación Vencida</option>
                    <option>Falta de Seguro</option>
                    <option>Sin Licencia</option>
                    <option>Estado del Vehículo</option>
                    <option>Situación Judicial</option>
                    <option>Actitud Sospechosa</option>
                    <option>Otro</option>
                </select>
            </div>

            {{-- A QUIÉN APLICA --}}
            <div>
                <label class="font-semibold">Aplica</label>
                <select name="aplica"
                    class="w-full mt-1 p-2 rounded-lg border"
                    style="background:var(--input); border-color:var(--border); color:var(--foreground);">
                    <option value="">— Seleccionar —</option>
                    <option>Vehículo</option>
                    <option>Conductor</option>
                    <option>Acompañante</option>
                </select>
            </div>

            {{-- OBSERVACIONES --}}
            <div>
                <label class="font-semibold">Observaciones</label>
                <textarea name="observaciones" rows="3"
                    class="w-full mt-1 p-2 rounded-lg border"
                    style="background:var(--input); border-color:var(--border); color:var(--foreground)"
                    placeholder="Detalles adicionales..."></textarea>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-4 mt-6">

                <button type="button"
                    @click="$dispatch('close-modal', 'modal-registrar-novedad')"
                    class="px-4 py-2 rounded-lg font-semibold"
                    style="background: var(--muted); color: var(--foreground);">
                    Cancelar
                </button>

                <button type="submit"
                    class="px-5 py-2 rounded-lg font-semibold shadow-lg
                        bg-red-600 text-white hover:bg-red-700">
                    Registrar
                </button>

            </div>

        </form>

    </div>

</x-modal-simple>


{{-- SCRIPT ALPINE --}}
<script>
function modalVehiculoConductor() {
    return {
        tab: 'vehiculo',
    };
}
</script>

</x-app-layout>
