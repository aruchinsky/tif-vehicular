<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Control Policial
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
            <div
                x-data="controlPersonal({{ $cargoOperadorId ?? 'null' }})"
                x-init="init()"
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

                    {{-- BOTÓN NUEVO POLICÍA --}}
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
                    <div class="flex items-center justify-between border-b py-3 gap-3">

                        <div>
                            <p class="font-semibold" x-text="item.nombre"></p>
                        </div>

                        {{-- SELECT ROL + AVISO --}}
<div class="flex items-center gap-3">

    {{-- SELECT DEL ROL --}}
    <select
        class="rounded"
        x-model="item.rol_id"
        @change="onRolChange(item)"
        :name="'roles['+item.id+']'"
    >
        @foreach ($cargos as $cargo)
            <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
        @endforeach
    </select>

    {{-- AVISO + BOTÓN → EN LA MISMA FILA --}}
    <template x-if="item.necesita_usuario">
        <div class="flex items-center gap-2 text-xs text-amber-600">

            <span>⚠ Sin usuario</span>

            <button type="button"
                    class="px-2 py-1 rounded bg-[var(--secondary)] text-white text-xs"
                    @click="
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-crear-usuario' }));
                        window.dispatchEvent(new CustomEvent('set-personal-id', { detail: item.id }));
                    ">
                Crear Usuario
            </button>

        </div>
    </template>

</div>


                        {{-- HIDDEN INPUT PERSONAL --}}
                        <input type="hidden" :name="'personal[]'" :value="item.id">

                        {{-- BOTÓN QUITAR --}}
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

    {{-- MODAL CREAR USUARIO --}}
    <x-modal-simple name="modal-crear-usuario" maxWidth="lg">
        @include('modules.ControlPolicial.partials.modal-crear-usuario')
    </x-modal-simple>

    {{-- SCRIPT ALPINE --}}
    <script>
        let ultimoPolicialCreado = null;

        // ESCUCHA GLOBAL DEL POLICÍA CREADO
        window.addEventListener('policial-creado', e => {
            ultimoPolicialCreado = {
                id: e.detail.id,
                nombre: e.detail.nombre
            };
        });

        // ESCUCHA GLOBAL DEL USUARIO CREADO
        window.addEventListener('usuario-creado', e => {
            let id = e.detail.personal_id;

            // Actualizar en create
            if (window.__controlPersonalInstance) {
                window.__controlPersonalInstance.marcarUsuarioCreado(id);
            }
        });

        function controlPersonal(cargoOperadorId) {
            return {
                cargoOperadorId,
                selected: "",
                asignados: [],

                // ⬇️ ACÁ CAMBIAMOS: JSON crudo + map en JS
                listaPersonal: (function () {
                    const raw = @json($personal);
                    return raw.map(p => ({
                        id: p.id,
                        nombre: p.nombre_apellido,
                        tiene_usuario: p.user_id !== null,
                    }));
                })(),

                init() {
                    window.__controlPersonalInstance = this;

                    // Cada 200ms chequeamos si hay uno nuevo del modal
                    setInterval(() => {
                        if (ultimoPolicialCreado !== null) {

                            this.asignados.push({
                                id: ultimoPolicialCreado.id,
                                nombre: ultimoPolicialCreado.nombre,
                                rol_id: null,
                                tiene_usuario: false,
                                necesita_usuario: false,
                            });

                            this.listaPersonal.push({
                                id: ultimoPolicialCreado.id,
                                nombre: ultimoPolicialCreado.nombre,
                                tiene_usuario: false,
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
                        rol_id: null,
                        tiene_usuario: p.tiene_usuario,
                        necesita_usuario: false,
                    });

                    this.selected = "";
                },

                quitar(id) {
                    this.asignados = this.asignados.filter(x => x.id != id);
                },

                onRolChange(item) {
                    if (!this.cargoOperadorId) return;

                    if (Number(item.rol_id) === Number(this.cargoOperadorId)) {

                        let persona = this.listaPersonal.find(x => x.id == item.id);
                        let tieneUsuario = persona ? persona.tiene_usuario : false;

                        item.tiene_usuario = tieneUsuario;
                        item.necesita_usuario = !tieneUsuario;

                    } else {
                        item.necesita_usuario = false;
                    }
                },

                marcarUsuarioCreado(id) {
                    // Actualizar lista principal
                    let p = this.listaPersonal.find(x => x.id == id);
                    if (p) p.tiene_usuario = true;

                    // Actualizar asignados
                    let a = this.asignados.find(x => x.id == id);
                    if (a) {
                        a.tiene_usuario = true;
                        a.necesita_usuario = false;
                    }
                }
            }
        }
    </script>

</x-app-layout>
