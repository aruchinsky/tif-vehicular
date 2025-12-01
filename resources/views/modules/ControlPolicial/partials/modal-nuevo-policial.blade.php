<div x-data="nuevoPolicial()" class="p-6">

    <h2 class="text-xl font-bold mb-4">Registrar Policía</h2>

    <div class="space-y-4">

        <div>
            <label class="font-semibold">Nombre y apellido</label>
            <input type="text" x-model="nombre" class="w-full rounded">
        </div>

        <div>
            <label class="font-semibold">Legajo</label>
            <input type="text" x-model="legajo" class="w-full rounded">
        </div>

        <div>
            <label class="font-semibold">DNI</label>
            <input type="text" x-model="dni" class="w-full rounded">
        </div>

        <div>
            <label class="font-semibold">Jerarquía</label>
            <input type="text" x-model="jerarquia" class="w-full rounded">
        </div>

        <div>
            <label class="font-semibold">Cargo policial</label>
            <select x-model="cargo_id" class="w-full rounded">
                <option value="">— Seleccionar —</option>
                @foreach ($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-semibold">Móvil (opcional)</label>
            <input type="text" x-model="movil" class="w-full rounded">
        </div>

    </div>

    <div class="mt-6 flex justify-end gap-3">

        <button type="button"
                x-on:click="window.dispatchEvent(new CustomEvent('close-modal'))"
                class="px-4 py-2 rounded bg-gray-200 text-gray-700">
            Cancelar
        </button>

        <button type="button"
                @click="guardar()"
                class="px-4 py-2 rounded bg-[var(--primary)] text-white">
            Guardar Policía
        </button>

    </div>

</div>

<script>
function nuevoPolicial() {
    return {
        nombre: "",
        legajo: "",
        dni: "",
        jerarquia: "",
        cargo_id: "",
        movil: "",

        guardar() {
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

                // Enviar al formulario principal
                window.dispatchEvent(new CustomEvent('policial-creado', {
                    detail: {
                        id: data.personal.id,
                        nombre: data.personal.nombre_apellido
                    }
                }));

                // Cerrar modal
                window.dispatchEvent(new CustomEvent('close-modal'));
            });
        }
    }
}
</script>
