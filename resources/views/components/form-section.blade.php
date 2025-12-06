@props(['submit'])

@php
    // Evitar errores cuando no existan slots
    $title = $title ?? null;
    $description = $description ?? null;
@endphp

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>

    {{-- ENCABEZADO SOLO SI EXISTEN SLOTS --}}
    @if ($title || $description)
        <x-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-section-title>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">

            {{-- FORMULARIO --}}
            <div class="px-4 py-5 bg-[var(--card)] text-[var(--foreground)] sm:p-6 shadow 
                        {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}"
                 style="border:1px solid var(--border);">
                 
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            {{-- FOOTER (ACCIONES) --}}
            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 
                            bg-[var(--muted)] text-[var(--foreground)]
                            sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif

        </form>
    </div>

</div>
