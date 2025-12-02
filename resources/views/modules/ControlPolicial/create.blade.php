<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Control Policial
    </x-slot>

            <div class="flex items-center gap-3 mb-6">

                {{-- Volver --}}
                <a href="{{ route('dashboard') }}"
                class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                        bg-[var(--primary)] text-[var(--primary-foreground)]
                        hover:opacity-90 transition">
                    ← Volver al Panel
                </a>
            </div>

    <form action="{{ route('controles.store') }}" method="POST">
        @csrf

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- CARD: Datos del Control --}}
            <div class="card p-6 shadow rounded-xl">
                <h3 class="text-xl font-bold mb-4">Datos del Operativo</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="font-semibold">Fecha</label>
                        <input type="date" name="fecha" class="w-full rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Lugar</label>
                        <input type="text" name="lugar" class="w-full rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Hora inicio</label>
                        <input type="time" name="hora_inicio" class="w-full rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Hora fin</label>
                        <input type="time" name="hora_fin" class="w-full rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Ruta</label>
                        <input type="text" name="ruta" class="w-full rounded">
                    </div>

                    <div>
                        <label class="font-semibold">Móvil asignado</label>
                        <input type="text" name="movil_asignado" class="w-full rounded">
                    </div>

                </div>
            </div>

            {{-- CARD: Personal asignado --}}
            <div x-data="controlPersonal()" x-init="init()" class="card p-6 shadow rounded-xl">

                <h3 class="text-xl font-bold mb-4">Personal Asignado</h3>

                {{-- SELECCIONAR POLICÍA --}}
                <div class="flex gap-4 items-end mb-6">

                    <div class="flex-1">
                        <label class="font-semibold">Seleccionar policía</label>

                        {{-- SELECT DINÁMICO --}}
                        <select x-model="selected" class="w-full rounded">
                            <option value="">— Seleccionar —</option>

                            <template x-for="p in listaPersonal" :key="p.id">
                                <option :value="p.id" x-text="p.nombre"></option>
                            </template>
                        </select>
                    </div>

                    {{-- BOTÓN AGREGAR --}}
                    <button type="button"
                            @click="agregar()"
                            class="px-4 py-2 bg-[var(--primary)] text-white rounded shadow">
                        Agregar
                    </button>

                    {{-- Abrir modal SIMPLE --}}
                    <button 
                        type="button"
                        class="px-4 py-2 rounded bg-[var(--secondary)] text-white"
                        @click="
                            window.dispatchEvent(
                                new CustomEvent('open-modal', { detail: 'modal-nuevo-policial' })
                            )
                        "
                    >
                        + Nuevo Policía
                    </button>

                </div>

                {{-- LISTA DE PERSONAL ASIGNADO --}}
                <template x-for="item in asignados" :key="item.id">
                    <div class="flex items-center justify-between border-b py-3">

                        <div>
                            <p class="font-semibold" x-text="item.nombre"></p>
                        </div>

                        {{-- SELECT ROL --}}
                        <select :name="'roles['+item.id+']'" class="rounded">
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}">
                                    {{ $cargo->nombre }}
                                </option>
                            @endforeach
                        </select>

                        {{-- HIDDEN INPUT --}}
                        <input type="hidden" :name="'personal[]'" :value="item.id">

                        <button type="button"
                                @click="quitar(item.id)"
                                class="text-red-500 font-bold">
                            ✖
                        </button>
                    </div>
                </template>

            </div>

            {{-- BOTÓN GUARDAR --}}
            <div class="text-right">
                <button class="px-6 py-3 bg-[var(--primary)] text-white rounded-lg shadow">
                    Guardar Control Policial
                </button>
            </div>

        </div>
    </form>

    {{-- MODAL NUEVO POLICÍA --}}
    <x-modal-simple name="modal-nuevo-policial" maxWidth="lg">
        @include('modules.ControlPolicial.partials.modal-nuevo-policial')
    </x-modal-simple>

    {{-- SCRIPT ALPINE --}}
    <script>
        // Variables globales temporales para comunicación modal → create
        let ultimoPolicialCreado = null;

        // Listener global del evento
        window.addEventListener('policial-creado', e => {
            ultimoPolicialCreado = {
                id: e.detail.id,
                nombre: e.detail.nombre
            };
        });

        function controlPersonal() {
            return {
                selected: "",
                asignados: [],

                listaPersonal: @json(
                    $personal->map(fn($p) => [
                        'id' => $p->id,
                        'nombre' => $p->nombre_apellido
                    ])
                ),

                init() {
                    // Cada 200ms chequeamos si hay uno nuevo agregado por el modal
                    setInterval(() => {

                        if (ultimoPolicialCreado !== null) {

                            // 1) Agregar a la lista de asignados
                            this.asignados.push({
                                id: ultimoPolicialCreado.id,
                                nombre: ultimoPolicialCreado.nombre
                            });

                            // 2) Agregar al select
                            this.listaPersonal.push({
                                id: ultimoPolicialCreado.id,
                                nombre: ultimoPolicialCreado.nombre
                            });

                            // Borrar buffer
                            ultimoPolicialCreado = null;
                        }

                    }, 200);
                },

                agregar() {
                    if (!this.selected) return;

                    if (this.asignados.some(a => a.id == this.selected)) {
                        return;
                    }

                    let item = this.listaPersonal.find(p => p.id == this.selected);

                    this.asignados.push({
                        id: item.id,
                        nombre: item.nombre
                    });

                    this.selected = "";
                },

                quitar(id) {
                    this.asignados = this.asignados.filter(x => x.id != id);
                }
            }
        }
    </script>


</x-app-layout>
