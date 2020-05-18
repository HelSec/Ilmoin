@props(['model'])

<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="font-bold text-2xl">
        Activity
    </div>

    <div class="px-2">
        @foreach($model->activityLogEntries as $logEntry)
            <div class="my-2">
                <div>
                    @if($logEntry->user)
                        <a href="{{ $logEntry->user->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $logEntry->user->name }}
                            </span>
                        </a>
                    @elseif($logEntry->user_id === 0 || $logEntry->user_id === null)
                        <span>Maintenance Script</span>
                    @else
                        <span>Deleted User #{{ $logEntry->user_id }}</span>
                    @endif
                    &middot;
                    {{ \App\Utils\Date::format($logEntry->created_at) }}
                </div>

                <div class="ml-2">
                    <table>
                        <tr>
                            <th class="pr-2 text-left">
                                Field
                            </th>

                            <th class="pr-2 text-left">
                                Original
                            </th>

                            <th class="text-left">
                                New
                            </th>
                        </tr>

                        @foreach($logEntry->data->diff as $key => $diff)
                            <tr>
                                <td class="pr-2 align-top">
                                    {{ $model->getFieldName($key) }}
                                </td>

                                <td class="pr-2 align-top">
                                    @if(is_array($diff->original))
                                        @foreach($diff->original as $value)
                                            @component('components.activity.value', ['typeModels' => $model->getFieldToModelTypes(), 'name' => $key, 'value' => $value])
                                            @endcomponent
                                            @if(!$loop->last)
                                                <br/>
                                            @endif
                                        @endforeach
                                    @else
                                        @component('components.activity.value', ['typeModels' => $model->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->original])
                                        @endcomponent
                                    @endif
                                </td>

                                <td class="align-top">
                                    @if(is_array($diff->new))
                                        @foreach($diff->new as $value)
                                            @component('components.activity.value', ['typeModels' => $model->getFieldToModelTypes(), 'name' => $key, 'value' => $value])
                                            @endcomponent
                                            @if(!$loop->last)
                                                <br/>
                                            @endif
                                        @endforeach
                                    @else
                                        @component('components.activity.value', ['typeModels' => $model->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->new])
                                        @endcomponent
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
