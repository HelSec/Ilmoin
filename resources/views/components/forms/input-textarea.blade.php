@props(['disabled' => false, 'value'])

<textarea  {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'form-textarea w-full  ' . ($disabled ? 'bg-gray-300 cursor-not-allowed' : '')]) }}>{{ $value }}</textarea>
