<x-form-section submit="updatePassword">

    <x-slot name="form">

        {{-- Contraseña actual --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="Contraseña actual" style="color: var(--foreground);" />
            <x-input id="current_password"
                     type="password"
                     class="mt-1 block w-full"
                     wire:model="state.current_password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        {{-- Nueva contraseña --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="Nueva contraseña" style="color: var(--foreground);" />
            <x-input id="password"
                     type="password"
                     class="mt-1 block w-full"
                     wire:model="state.password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        {{-- Confirmación --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="Confirmar nueva contraseña" style="color: var(--foreground);" />
            <x-input id="password_confirmation"
                     type="password"
                     class="mt-1 block w-full"
                     wire:model="state.password_confirmation" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">

        <x-action-message class="me-3" on="saved">
            Contraseña actualizada.
        </x-action-message>

        <button class="px-4 py-2 rounded-lg font-semibold shadow bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition">
            Guardar
        </button>

    </x-slot>

</x-form-section>
