@props(['title', 'description', 'element' => 'label'])
<{{ $element }} {{ $attributes->merge(['class' => 'block md:flex']) }}>
    <div class="md:w-1/3 pr-4">
        <div class="font-semibold text-black mb-2">{{ $title }}</div>
        <div class="text-gray-700 text-sm">{{ $description }}</div>
    </div>

    <div class="md:w-2/3">
        {{ $slot }}
    </div>
</{{ $element }}>
