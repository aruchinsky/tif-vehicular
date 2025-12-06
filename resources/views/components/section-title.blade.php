<div class="md:col-span-1 flex justify-between">

    <div class="px-4 sm:px-0">

        {{-- Título --}}
        <h3 class="text-lg font-semibold"
            style="color: var(--foreground);">
            {{ $title }}
        </h3>

        {{-- Descripción --}}
        <p class="mt-1 text-sm"
           style="color: var(--muted-foreground);">
            {{ $description }}
        </p>

    </div>

    {{-- Contenido opcional del costado --}}
    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>

</div>
