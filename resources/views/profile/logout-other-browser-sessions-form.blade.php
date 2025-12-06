<x-action-section>

    <x-slot name="content">

        <p class="text-sm" style="color: var(--muted-foreground);">
            Administrá tus sesiones activas en otros navegadores y dispositivos.
        </p>

        {{-- LISTA DE SESIONES --}}
        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-4">

                @foreach ($this->sessions as $session)
                    <div class="flex items-center gap-3 p-3 rounded-lg border shadow-sm"
                         style="background: var(--card); border-color: var(--border);">

                        {{-- ÍCONO --}}
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg class="w-7 h-7 text-[var(--muted-foreground)]" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 4h18v12H3V4zm3 16h12" />
                                </svg>
                            @else
                                <svg class="w-7 h-7 text-[var(--muted-foreground)]" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M7 2h10v20H7z" />
                                </svg>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm font-semibold" style="color: var(--foreground);">
                                {{ $session->agent->platform() ?? 'Desconocido' }} —
                                {{ $session->agent->browser() ?? 'Desconocido' }}
                            </p>

                            <p class="text-xs" style="color: var(--muted-foreground);">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-600 font-semibold">Este dispositivo</span>
                                @else
                                    Última actividad: {{ $session->last_active }}
                                @endif
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif


        {{-- BOTÓN PRINCIPAL --}}
        <div class="flex items-center mt-6">
            <button wire:click="confirmLogout"
                    class="px-4 py-2 rounded-lg font-semibold shadow bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition">
                Cerrar sesión en otros dispositivos
            </button>

            <x-action-message class="ms-3" on="loggedOut">
                Hecho.
            </x-action-message>
        </div>


        {{-- MODAL --}}
        <x-dialog-modal wire:model.live="confirmingLogout">

            <x-slot name="title">
                Confirmar cierre de sesiones
            </x-slot>

            <x-slot name="content">
                Ingresá tu contraseña para confirmar.

                <div class="mt-4"
                     x-data
                     x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">

                    <x-input type="password"
                             class="mt-1 block w-3/4"
                             placeholder="Contraseña"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="px-4 py-2 rounded-lg bg-gray-300 dark:bg-gray-700 text-black dark:text-white"
                        wire:click="$toggle('confirmingLogout')">
                    Cancelar
                </button>

                <button class="ms-3 px-4 py-2 rounded-lg bg-[var(--primary)] text-[var(--primary-foreground)]"
                        wire:click="logoutOtherBrowserSessions">
                    Confirmar
                </button>
            </x-slot>

        </x-dialog-modal>

    </x-slot>

</x-action-section>
