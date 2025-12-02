<div x-data="nuevoPolicial()" class="p-6 space-y-6">

    {{-- TÍTULO --}}
    <h2 class="text-xl font-bold" style="color: var(--primary);">
        Registrar Nuevo Policía
    </h2>

    {{-- FORMULARIO --}}
    <div class="space-y-4">

        {{-- Nombre --}}
        <div>
            <label class="font-semibold block mb-1">Nombre y apellido</label>
            <input type="text"
                   x-model="nombre"
                   class="w-full rounded-lg border p-2"
                   style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">
        </div>

        {{-- Legajo --}}
        <div>
            <label class="font-semibold block mb-1">Legajo</label>
            <input type="text"
                   x-model="legajo"
                   class="w-full rounded-lg border p-2"
                   style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">
        </div>

        {{-- DNI --}}
        <div>
            <label class="font-semibold block mb-1">DNI</label>
            <input type="text"
                   x-model="dni"
                   class="w-full rounded-lg border p-2"
                   style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">
        </div>

        {{-- Jerarquía --}}
        <div>
            <label class="font-semibold block mb-1">Jerarquía</label>
            <input type="text"
                   x-model="jerarquia"
                   class="w-full rounded-lg border p-2"
                   style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">
        </div>

        {{-- Cargo --}}
        <div>
            <label class="font-semibold block mb-1">Cargo policial</label>
            <select x-model="cargo_id"
                    class="w-full rounded-lg border p-2"
                    style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">

                <option value="">— Seleccionar —</option>

                @foreach ($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach

            </select>
        </div>

        {{-- Móvil --}}
        <div>
            <label class="font-semibold block mb-1">Móvil (opcional)</label>
            <input type="text"
                   x-model="movil"
                   class="w-full rounded-lg border p-2"
                   style="background: var(--input); color: var(--input-foreground); border-color: var(--border);">
        </div>

    </div>

    {{-- BOTONES --}}
    <div class="flex justify-end gap-3 pt-4">

        {{-- CANCELAR --}}
        <button type="button"
            @click="cerrarModal()"
            class="px-4 py-2 rounded-lg font-semibold shadow
                   transition bg-[var(--muted)] text-[var(--muted-foreground)]
                   hover:opacity-80">
            Cancelar
        </button>

        {{-- GUARDAR --}}
        <button type="button"
            @click="guardar()"
            class="px-4 py-2 rounded-lg font-semibold shadow
                   bg-[var(--primary)] text-[var(--primary-foreground)]
                   hover:opacity-80 transition">
            Guardar Policía
        </button>

    </div>

</div>


{{-- SCRIPT --}}
<script>
function nuevoPolicial() {
    return {
        nombre: "",
        legajo: "",
        dni: "",
        jerarquia: "",
        cargo_id: "",
        movil: "",
        guardando: false,

        cerrarModal() {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'modal-nuevo-policial' }));
        },

        guardar() {
            if (this.guardando) return;
            this.guardando = true;

            fetch("{{ route('personal.store-ajax') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    nombre_apellido: this.nombre,
                    legajo: this.legajo,
                    dni: this.dni,
                    jerarquia: this.jerarquia,
                    cargo_id: this.cargo_id,
                    movil: this.movil
                })
            })
            .then(r => r.json())
            .then(data => {

                if (data.status === "ok") {

                    // Notificar al formulario principal (create o edit)
                    window.dispatchEvent(new CustomEvent('policial-creado', {
                        detail: {
                            id: data.personal.id,
                            nombre: data.personal.nombre_apellido
                        }
                    }));

                    this.cerrarModal();
                }

            })
            .catch(err => console.error("ERROR AJAX:", err))
            .finally(() => {
                this.guardando = false;
            });
        }
    }
}
</script>
