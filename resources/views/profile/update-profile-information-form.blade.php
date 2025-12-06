<x-form-section submit="updateProfileInformation">

    <x-slot name="form">

        {{-- FOTO DE PERFIL --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}"
                 class="col-span-6 sm:col-span-4">

                <x-label for="photo" value="Foto de perfil" style="color: var(--foreground);" />

                <!-- Actual -->
                <div class="mt-3" x-show="!photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}"
                         alt="{{ $this->user->name }}"
                         class="rounded-full size-24 border shadow"
                         style="border-color: var(--border);">
                </div>

                <!-- Nueva -->
                <div class="mt-3" x-show="photoPreview" style="display:none;">
                    <span class="block rounded-full size-24 bg-cover bg-no-repeat bg-center border shadow"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\'); border-color: var(--border)'">
                    </span>
                </div>

                <!-- Input -->
                <input type="file" class="hidden"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => photoPreview = e.target.result;
                            reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <div class="flex items-center gap-2 mt-3">
                    <button type="button"
                            class="px-4 py-2 rounded-lg text-sm font-semibold shadow bg-[var(--muted)] text-[var(--foreground)] hover:opacity-80 transition"
                            x-on:click.prevent="$refs.photo.click()">
                        Seleccionar nueva foto
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button"
                                class="px-4 py-2 rounded-lg text-sm font-semibold shadow bg-red-600 text-white hover:bg-red-700 transition"
                                wire:click="deleteProfilePhoto">
                            Eliminar foto
                        </button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif


        {{-- NOMBRE --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="Nombre" style="color: var(--foreground);" />
            <x-input id="name"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model="state.name"
                     required />
            <x-input-error for="name" class="mt-2" />
        </div>


        {{-- EMAIL --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="Correo electrónico" style="color: var(--foreground);" />
            <x-input id="email"
                     type="email"
                     class="mt-1 block w-full"
                     wire:model="state.email"
                     required />
            <x-input-error for="email" class="mt-2" />

            {{-- Verificación de email --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-xs mt-2" style="color: var(--muted-foreground);">
                    Tu correo aún no está verificado.

                    <button type="button"
                            wire:click.prevent="sendEmailVerification"
                            class="underline text-[var(--primary)] hover:opacity-80">
                        Reenviar correo de verificación.
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-xs text-green-600">
                        Se envió un nuevo enlace de verificación.
                    </p>
                @endif
            @endif
        </div>
    </x-slot>


    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            Guardado correctamente.
        </x-action-message>

        <button class="px-4 py-2 rounded-lg font-semibold shadow bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition"
                wire:loading.attr="disabled">
            Guardar cambios
        </button>
    </x-slot>

</x-form-section>
