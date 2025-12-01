<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Control Policial
    </x-slot>

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
                        <select x-model="selected" class="w-full rounded">
                            <option value="">— Seleccionar —</option>

                            @foreach ($personal as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nombre_apellido }} — {{ $p->cargo->nombre ?? 'Sin cargo' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button"
                            @click="agregar()"
                            class="px-4 py-2 bg-[var(--primary)] text-white rounded shadow">
                        Agregar
                    </button>

                    {{-- Abrir modal SIMPLE --}}
                    <button 
                        type="button"
                        class="px-4 py-2 rounded bg-[var(--secondary)] text-white"
                        x-on:click="
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

    {{-- MODAL NUEVO POLICÍA USANDO NUESTRO COMPONENTE SIMPLE --}}
    <x-modal-simple name="modal-nuevo-policial" maxWidth="lg">
        @include('modules.ControlPolicial.partials.modal-nuevo-policial')
    </x-modal-simple>

    {{-- SCRIPT ALPINE --}}
    <script>
        function controlPersonal() {
            return {
                selected: "",
                asignados: [],

                init() {
                    window.addEventListener('policial-creado', e => {
                        this.asignados.push({
                            id: e.detail.id,
                            nombre: e.detail.nombre
                        });
                    });
                },

                agregar() {
                    if (!this.selected) return;

                    let select = document.querySelector('select[x-model="selected"]') ?? 
                                 event.target.closest('div').querySelector("select");

                    let option = select.selectedOptions[0];

                    this.asignados.push({
                        id: this.selected,
                        nombre: option.textContent,
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
