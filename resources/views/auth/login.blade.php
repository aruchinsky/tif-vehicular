<x-guest-layout>

    <style>
        /* --- Fondo completo --- */
        body {
            background: url('{{ asset('fondo.jpeg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        /* --- Contenedor tipo vidrio (glassmorphism) --- */
        .glass-card {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.45); /* Oscurito pero transparente */
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        /* --- Centrado hacia la derecha --- */
        .login-wrapper {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            min-height: 100vh;
            padding-right: 4rem; /* Ajustá si querés más o menos separación del borde */
        }
    </style>

    <div class="login-wrapper">

        <div class="glass-card w-full max-w-md">

            {{-- Logo del sistema --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.png') }}" class="h-20 w-auto" alt="Logo Sistema">
            </div>

            {{-- Validaciones --}}
            <x-validation-errors class="mb-4 text-white" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-400">
                    {{ $value }}
                </div>
            @endsession

            {{-- Formulario --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="text-white">
                    <x-label for="email" value="{{ __('Email') }}" class="text-white"/>
                    <x-input id="email"
                             class="block mt-1 w-full bg-white/20 text-white placeholder-white/70 border-white/30 focus:border-blue-400 focus:ring-blue-400"
                             type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                {{-- Password --}}
                <div class="mt-4 text-white">
                    <x-label for="password" value="{{ __('Contraseña') }}" class="text-white"/>
                    <x-input id="password"
                             class="block mt-1 w-full bg-white/20 text-white placeholder-white/70 border-white/30 focus:border-blue-400 focus:ring-blue-400"
                             type="password" name="password" required autocomplete="current-password" />
                </div>

                {{-- Remember me --}}
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center text-white">
                        <x-checkbox id="remember_me" name="remember" class="text-white"/>
                        <span class="ms-2 text-sm text-white">{{ __('Recuérdame') }}</span>
                    </label>
                </div>

                {{-- Botón + Olvidé mi contraseña --}}
                <div class="flex items-center justify-between mt-6">

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-200 hover:text-white"
                           href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <x-button class="ms-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                        {{ __('Iniciar Sesión') }}
                    </x-button>
                </div>

            </form>
        </div>

    </div>

</x-guest-layout>
