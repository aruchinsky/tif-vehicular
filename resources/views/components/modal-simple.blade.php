@props(['name', 'maxWidth' => '2xl'])

@php
$maxWidthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div
    x-data="{
        show: false,
        close() {
            this.show = false;
            document.body.classList.remove('overflow-hidden');
        },
        open() {
            this.show = true;
            document.body.classList.add('overflow-hidden');
        }
    }"
    x-cloak

    @open-modal.window="if ($event.detail === '{{ $name }}') open()"
    @close-modal.window="if ($event.detail === '{{ $name }}') close()"

    class="fixed inset-0 z-50 flex items-start justify-center px-4 py-6 sm:px-0 overflow-y-auto pointer-events-none"
>

    {{-- Fondo oscuro --}}
    <div
        x-show="show"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-70 pointer-events-auto"
        @click="close()"
    ></div>

    {{-- Contenido del modal --}}
    <div
        x-show="show"
        x-transition.scale.origin.top
        class="relative mt-24 w-full {{ $maxWidthClass }} sm:mx-auto pointer-events-auto
               rounded-xl shadow-xl
               bg-[var(--card)] text-[var(--card-foreground)]
        "
        @keydown.escape.window="close()"
    >
        {{ $slot }}
    </div>

</div>
