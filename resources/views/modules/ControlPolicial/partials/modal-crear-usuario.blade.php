<div x-data="crearUsuarioModal()" 
     x-on:set-personal-id.window="personalId = $event.detail"
     class="p-4">


    <h2 class="text-xl font-bold mb-4">Crear usuario del sistema</h2>

    {{-- ERRORES --}}
    <template x-if="errores.length > 0">
        <div class="mb-4 p-3 rounded border border-red-400 bg-red-100 text-red-700 text-sm">
            <ul class="list-disc ml-4 space-y-1">
                <template x-for="err in errores">
                    <li x-text="err"></li>
                </template>
            </ul>
        </div>
    </template>

    <form method="POST"
          action="{{ route('personal.storeUsuario') }}"
          @submit.prevent="submit($event)">
        
        @csrf

        {{-- ID del personal --}}
        <input type="hidden" name="personal_id" x-model="personalId">

        {{-- EMAIL --}}
        <div>
            <label class="font-semibold text-sm">Correo electrónico</label>
            <input type="email"
                   name="email"
                   class="w-full rounded mt-1"
                   x-model="email"
                   required>
        </div>

        <p class="text-xs text-gray-600 mt-2">
            La contraseña será el DNI del personal.
        </p>

        <div class="flex justify-end gap-2 mt-6">

            <button type="button"
                    class="px-4 py-2 rounded border"
                    @click="closeModal()">
                Cancelar
            </button>

            <button type="submit"
                    class="px-4 py-2 rounded bg-[var(--primary)] text-white">
                Crear usuario
            </button>

        </div>

    </form>

</div>

<script>
function crearUsuarioModal() {
    return {
        personalId: null,
        email: '',
        errores: [],

        submit(event) {
            this.errores = []; // limpiar errores anteriores

            let form = event.target;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { "Accept": "application/json" }
            })
.then(async r => {

    // Intentar convertir la respuesta a JSON
    let data = null;
    try {
        data = await r.json();
    } catch (e) {
        this.errores = ['El servidor devolvió una respuesta inválida (no JSON). Posible error 500.'];
        return;
    }

    // ERRORES 422 → validación
    if (r.status === 422) {
        if (data.errors) {
            this.errores = Object.values(data.errors).flat();
        } else {
            this.errores = ['Error de validación desconocido'];
        }
        return;
    }

    // ÉXITO
    if (data.status === 'ok') {
        window.dispatchEvent(new CustomEvent('usuario-creado', {
            detail: { personal_id: data.personal_id }
        }));

        this.closeModal();
        return;
    }

    // ⚠️ MOSTRAR ERROR REAL SI EXISTE
    if (data.message) {
        this.errores = [data.message];
        return;
    }

    // DEFAULT
    this.errores = ['Error inesperado (sin mensaje)'];
})
.catch(err => {
    this.errores = ['Error crítico: ' + err.message];
});

        },

        closeModal() {
            this.errores = [];
            this.email = '';
            window.dispatchEvent(
                new CustomEvent('close-modal', { detail: 'modal-crear-usuario' })
            );
        }
    }
}

</script>
