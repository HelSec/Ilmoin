@if(array_key_exists($name, $typeModels))
    <?php
    /** @var array $typeModels */
    /** @var string $name */
    /** @var int $value */
    $data = $typeModels[$name];
    $model = ($data[0])::where($data[1], $value)->first(); ?>
    @if($model)
        <a href="{{ $model->viewUrl }}">
            <span class="hover:underline text-gray-900 hover:text-black group">
                <span class="text-gray-700 group-hover:text-gray-900">
                    ({{ $model->id }})
                </span>

                {{ $model->name ?? $model->tag }}
            </span>
        </a>
    @endif
@elseif($value === null)
    {{-- nothing --}}
@elseif($value === true)
    True
@elseif($value === false)
    False
@elseif(strtotime($value) !== false || $value instanceof DateTime)
    {{ \App\Utils\Date::format($value) }}
@else
    {{ $value }}
@endif
