@props(['name', 'class' => 'w-6 h-6'])

<x-dynamic-component 
    :component="'icons.' . $name"
    :class="$class" 
/>
