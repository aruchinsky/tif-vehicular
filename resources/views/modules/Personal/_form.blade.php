{{-- resources/views/modules/Personal/_form.blade.php --}}

@php
    $isEdit = isset($personal);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Nombre y apellido --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            Nombre y Apellido <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="nombre_apellido"
               value="{{ old('nombre_apellido', $personal->nombre_apellido ?? '') }}"
               class="w-full rounded-lg border px-3 py-2 text-sm"
               style="background: var(--background); color: var(--foreground); border-color: var(--border);">
        @error('nombre_apellido')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Legajo --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            Legajo
        </label>
        <input type="text"
               name="legajo"
               value="{{ old('legajo', $personal->legajo ?? '') }}"
               class="w-full rounded-lg border px-3 py-2 text-sm"
               style="background: var(--background); color: var(--foreground); border-color: var(--border);">
        @error('legajo')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- DNI --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            DNI <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="dni"
               value="{{ old('dni', $personal->dni ?? '') }}"
               class="w-full rounded-lg border px-3 py-2 text-sm"
               style="background: var(--background); color: var(--foreground); border-color: var(--border);">
        @error('dni')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jerarquía --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            Jerarquía
        </label>
        <input type="text"
               name="jerarquia"
               value="{{ old('jerarquia', $personal->jerarquia ?? '') }}"
               class="w-full rounded-lg border px-3 py-2 text-sm"
               style="background: var(--background); color: var(--foreground); border-color: var(--border);">
        @error('jerarquia')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Cargo policial --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            Cargo policial
        </label>
        <select name="cargo_id"
                class="w-full rounded-lg border px-3 py-2 text-sm"
                style="background: var(--background); color: var(--foreground); border-color: var(--border);">
            <option value="">Sin asignar</option>
            @foreach ($cargos as $cargo)
                <option value="{{ $cargo->id }}"
                    @selected(old('cargo_id', $personal->cargo_id ?? null) == $cargo->id)>
                    {{ $cargo->nombre }}
                </option>
            @endforeach
        </select>
        @error('cargo_id')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Móvil policial --}}
    <div>
        <label class="block text-sm font-medium mb-1"
               style="color: var(--foreground);">
            Móvil asignado
        </label>
        <input type="text"
               name="movil"
               value="{{ old('movil', $personal->movil ?? '') }}"
               class="w-full rounded-lg border px-3 py-2 text-sm"
               style="background: var(--background); color: var(--foreground); border-color: var(--border);">
        @error('movil')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>

{{-- FOOTER BOTONES --}}
<div class="mt-6 flex items-center justify-between gap-3">
    <a href="{{ route('personal.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-semibold border shadow-sm hover:opacity-90 transition"
       style="border-color: var(--border); color: var(--muted-foreground); background: var(--card);">
        Cancelar
    </a>

    <button type="submit"
            class="px-4 py-2 rounded-lg text-sm font-semibold shadow hover:opacity-90 transition"
            style="background: var(--primary); color: var(--primary-foreground);">
        {{ $isEdit ? 'Guardar cambios' : 'Registrar personal' }}
    </button>
</div>
