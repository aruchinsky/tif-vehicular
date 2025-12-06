{{-- resources/views/modules/Personal/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold" style="color: var(--foreground);">
            Registrar nuevo personal
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- Errores generales --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg border text-sm"
                 style="background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.8); color: var(--foreground);">
                <p class="font-semibold mb-1">Revisá los campos marcados.</p>
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-lg border rounded-2xl"
             style="background: var(--card); border-color: var(--border);">

            <div class="px-6 py-4 border-b"
                 style="border-color: var(--border); background: var(--muted);">
                <h3 class="text-sm font-semibold" style="color: var(--foreground);">
                    Datos del efectivo
                </h3>
            </div>

            <div class="px-6 py-6">
                <form action="{{ route('personal.store') }}" method="POST">
                    @csrf

                    @include('modules.Personal._form', ['personal' => null, 'cargos' => $cargos])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
