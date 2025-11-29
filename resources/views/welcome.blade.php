<x-guest-layout>
    <div class="text-center py-20">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            Sistema de Control Vehicular
        </h1>

        <p class="text-gray-600 mb-8">
            Iniciá sesión para continuar
        </p>

        <a href="{{ route('login') }}"
           class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
            Iniciar Sesión
        </a>
    </div>
</x-guest-layout>
