<x-action-section>

    <x-slot name="content">

        <p class="text-sm" style="color: var(--muted-foreground);">
            Al eliminar tu cuenta, todos tus datos serán borrados permanentemente.
        </p>

        <div class="mt-5">
            <button wire:click="confirmUserDeletion"
                    class="px-4 py-2 rounded-lg font-semibold shadow bg-red-600 text-white hover:bg-red-700 transition">
                Eliminar cuenta
            </button>
        </div>


        {{-- MODAL --}}
        <x-dialog-modal wire:model.live="confirmingUserDeletion">

            <x-slot name="title">
                ¿Eliminar cuenta?
            </x-slot>

            <x-slot name="content">
                Ingresá tu contraseña para confirmar.

                <div class="mt-4"
                     x-data
                     x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">

                    <x-input type="password"
                             class="mt-1 block w-3/4"
                             placeholder="Contraseña"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>


            <x-slot name="footer">
                <button class="px-4 py-2 rounded-lg bg-gray-300 dark:bg-gray-700 text-black dark:text-white"
                        wire:click="$toggle('confirmingUserDeletion')">
                    Cancelar
                </button>

                <button class="ms-3 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
                        wire:click="deleteUser">
                    Eliminar definitivamente
                </button>
            </x-slot>

        </x-dialog-modal>

    </x-slot>

</x-action-section>
