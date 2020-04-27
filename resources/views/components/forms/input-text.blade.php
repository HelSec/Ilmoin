@props(['disabled' => false, 'type'])

<input type="{{ $type ?? 'text' }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'form-input w-full  ' . ($disabled ? 'bg-gray-300 cursor-not-allowed' : '')]) }}>
