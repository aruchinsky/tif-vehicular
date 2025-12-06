<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>

    {{-- TÍTULO Y DESCRIPCIÓN (si existen) --}}
    <x-section-title>
        <x-slot name="title">{{ $title ?? '' }}</x-slot>
        <x-slot name="description">{{ $description ?? '' }}</x-slot>
        <x-slot name="aside">{{ $aside ?? '' }}</x-slot>
    </x-section-title>

    {{-- CONTENIDO --}}
    <div class="mt-5 md:mt-0 md:col-span-2">

        <div class="px-4 py-5 sm:p-6 shadow sm:rounded-lg"
             style="
                background-color: var(--card);
                color: var(--foreground);
                border: 1px solid var(--border);
             ">
            {{ $content }}
        </div>

    </div>

</div>
