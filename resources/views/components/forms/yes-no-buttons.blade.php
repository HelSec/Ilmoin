@props(['value' => true, 'name'])

<label class="block">
    <input type="radio" {{ $attributes->merge(['class' => 'form-radio']) }} class="form-radio" name="{{ $name }}" value="1" {{ $value ? 'checked' : '' }}> Yes
</label>

<label class="block">
    <input type="radio" {{ $attributes->merge(['class' => 'form-radio']) }} name="{{ $name }}" value="0" {{ !$value ? 'checked' : '' }}> No
</label>
