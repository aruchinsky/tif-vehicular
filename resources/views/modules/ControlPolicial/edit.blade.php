<x-app-layout>
    <x-slot name="header">
        Editar Control Policial
    </x-slot>

    {{-- BOTÓN VOLVER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard') }}"
           class="px-4 py-2 rounded-lg font-semibold text-sm shadow
                  bg-[var(--primary)] text-[var(--primary-foreground)]
                  hover:opacity-90 transition">
            ← Volver al Panel
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
            <p class="font-bold mb-2">Errores:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('controles.update', $control) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- CARD: Datos del Control --}}
            <div class="card p-6 shadow rounded-xl">
                <h3 class="text-xl font-bold mb-4">Datos del Operativo</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="font-semibold">Fecha</label>
                        <input type="date"
                               name="fecha"
                               class="w-full rounded"
                               value="{{ old('fecha', $control->fecha) }}"
                               required>
                    </div>

                    <div>
                        <label class="font-semibold">Lugar</label>
                        <input type="text"
                               name="lugar"
                               class="w-full rounded"
                               value="{{ old('lugar', $control->lugar) }}"
                               required>
                    </div>

                    <div>
                        <label class="font-semibold">Hora inicio</label>
                        <input type="time"
                            name="hora_inicio"
                            class="w-full rounded"
                            value="{{ old('hora_inicio', \Carbon\Carbon::parse($control->hora_inicio)->format('H:i')) }}"
                            required>

                    </div>

                    <div>
                        <label class="font-semibold">Hora fin</label>
                        <input type="time"
                            name="hora_fin"
                            class="w-full rounded"
                            value="{{ old('hora_fin', \Carbon\Carbon::parse($control->hora_fin)->format('H:i')) }}"
                            required>
                    </div>

                    <div>
                        <label class="font-semibold">Ruta</label>
                        <input type="text"
                               name="ruta"
                               class="w-full rounded"
                               value="{{ old('ruta', $control->ruta) }}">
                    </div>

                    <div>
                        <label class="font-semibold">Móvil asignado</label>
                        <input type="text"
                               name="movil_asignado"
                               class="w-full rounded"
                               value="{{ old('movil_asignado', $control->movil_asignado) }}">
                    </div>

                </div>
            </div>

            {{-- CARD: Personal asignado --}}
            <div
                x-data="controlPersonalEdit(
                    JSON.parse($el.getAttribute('data-asignados')),
                    JSON.parse($el.getAttribute('data-listapersonal'))
                )"
                x-init="init()"
                data-asignados='@json($asignados)'
                data-listapersonal='@json($listaPersonal)'
                class="card p-6 shadow rounded-xl"
            >

                <h3 class="text-xl font-bold mb-4">Personal Asignado</h3>

                {{-- SELECCIONAR POLICÍA --}}
                <div class="flex gap-4 items-end mb-6">

                    <div class="flex-1">
                        <label class="font-semibold">Seleccionar policía</label>

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

                    {{-- Abrir modal --}}
                    <button type="button"
                            class="px-4 py-2 rounded bg-[var(--secondary)] text-white"
                            @click="
                                window.dispatchEvent(
                                    new CustomEvent('open-modal', { detail: 'modal-nuevo-policial' })
                                )
                            ">
                        + Nuevo Policía
                    </button>

                </div>

                {{-- LISTA DE PERSONAL ASIGNADO --}}
                <template x-for="item in asignados" :key="item.id">
                    <div class="flex items-center justify-between border-b py-3 gap-3">

                        <div class="flex-1">
                            <p class="font-semibold" x-text="item.nombre"></p>
                        </div>

                        {{-- SELECT ROL --}}
                        <div>
                            <select class="rounded" x-model="item.rol_id">
                                @foreach ($cargos as $cargo)
                                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                @endforeach
                            </select>

                            <input type="hidden"
                                   :name="'roles['+item.id+']'"
                                   :value="item.rol_id">
                        </div>

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
                    Actualizar Control Policial
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
    let ultimoPolicialCreado = null;

    window.addEventListener('policial-creado', e => {
        ultimoPolicialCreado = {
            id: e.detail.id,
            nombre: e.detail.nombre
        };
    });

    const defaultRolId = {{ $cargos->first()?->id ?? 'null' }};

    function controlPersonalEdit(asignadosInit, listaInit) {
        return {
            selected: "",
            asignados: asignadosInit,
            listaPersonal: listaInit,

            init() {
                setInterval(() => {
                    if (ultimoPolicialCreado !== null) {

                        this.asignados.push({
                            id: ultimoPolicialCreado.id,
                            nombre: ultimoPolicialCreado.nombre,
                            rol_id: defaultRolId,
                        });

                        this.listaPersonal.push({
                            id: ultimoPolicialCreado.id,
                            nombre: ultimoPolicialCreado.nombre
                        });

                        ultimoPolicialCreado = null;
                    }
                }, 200);
            },

            agregar() {
                if (!this.selected) return;

                if (this.asignados.some(a => a.id == this.selected)) {
                    return;
                }

                let p = this.listaPersonal.find(x => x.id == this.selected);

                this.asignados.push({
                    id: p.id,
                    nombre: p.nombre,
                    rol_id: defaultRolId,
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
