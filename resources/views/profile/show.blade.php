<x-app-layout>

    {{-- =============================================== --}}
    {{-- ===================== HEADER ================== --}}
    {{-- =============================================== --}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <svg class="w-7 h-7 text-[var(--primary)]" fill="none" stroke="currentColor" stroke-width="1.8"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z" />
            </svg>

            <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
                Mi Perfil
            </h2>
        </div>

        <p class="text-sm" style="color: var(--muted-foreground);">
            Gestioná la información de tu cuenta, seguridad y actividad.
        </p>
    </x-slot>


    {{-- =============================================== --}}
    {{-- ============== CONTENEDOR PRINCIPAL =========== --}}
    {{-- =============================================== --}}
    <div class="max-w-5xl mx-auto py-10 px-4 space-y-10">

        {{-- =============================================== --}}
        {{-- ========== INFORMACIÓN DE PERFIL ============== --}}
        {{-- =============================================== --}}
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="rounded-xl shadow border p-6"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-xl font-semibold mb-4" style="color: var(--foreground);">
                    Información del Perfil
                </h3>

                @livewire('profile.update-profile-information-form')
            </div>
        @endif



        {{-- =============================================== --}}
        {{-- =========== ACTUALIZAR CONTRASEÑA ============= --}}
        {{-- =============================================== --}}
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="rounded-xl shadow border p-6"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-xl font-semibold mb-4" style="color: var(--foreground);">
                    Seguridad: Contraseña
                </h3>

                @livewire('profile.update-password-form')
            </div>
        @endif



        {{-- =============================================== --}}
        {{-- ====== AUTENTICACIÓN DE DOS FACTORES (si aplica) --}}
        {{-- =============================================== --}}
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="rounded-xl shadow border p-6"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-xl font-semibold mb-4" style="color: var(--foreground);">
                    Autenticación en Dos Pasos
                </h3>

                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif



        {{-- =============================================== --}}
        {{-- ======= SESIONES EN OTROS NAVEGADORES ========= --}}
        {{-- =============================================== --}}
        <div class="rounded-xl shadow border p-6"
             style="background: var(--card); border-color: var(--border);">

            <h3 class="text-xl font-semibold mb-4" style="color: var(--foreground);">
                Actividad y Sesiones
            </h3>

            @livewire('profile.logout-other-browser-sessions-form')
        </div>



        {{-- =============================================== --}}
        {{-- ============ ELIMINAR CUENTA ================== --}}
        {{-- =============================================== --}}
        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="rounded-xl shadow border p-6"
                 style="background: var(--card); border-color: var(--border);">

                <h3 class="text-xl font-semibold mb-4 text-red-600">
                    Eliminación de Cuenta
                </h3>

                @livewire('profile.delete-user-form')
            </div>
        @endif

    </div>

</x-app-layout>
