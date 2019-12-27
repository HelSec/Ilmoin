@extends('layouts.master')

@section('title', $event->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        {{ $event->name }}
                    </div>

                    <div>
                        @auth
                            @can('attend', $event)
                                <a href="{{ route('events.register', $event) }}" class="button-pink">
                                    Register
                                </a>
                            @elsecan('cancel', $event)
                                <a href="{{ route('events.cancel', $event) }}" class="button-pink">
                                    Cancel
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="font-bold hover:underline text-black">
                                Log in to attend
                            </a>
                        @endif
                    </div>
                </div>

                <div class="text-gray-800 my-2">
                    Hosted by <a href="{{ route('organizations.show', $event->organization) }}" class="text-black hover:underline">{{ $event->organization->name }}</a>.
                </div>

                <div class="flex my-2">
                    <div class="text-gray-700">
                        <i class="fas fa-calendar"></i>
                        {{ \App\Utils\Date::format($event->date) }}
                    </div>

                    <div class="text-gray-700 ml-4">
                        <i class="fas fa-location-arrow"></i>
                        {{ $event->location }}
                    </div>

                    @if($event->max_slots !== null)
                        <div class="text-grey-700 ml-4">
                            <i class="fas fa-users"></i>
                            {{ $event->max_slots }} slots
                        </div>
                    @endif
                </div>

                <div class="text-gray-700 text-base">
                    @parsedown($event->description)
                </div>
            </div>
        </div>
    </div>

    @can('manage', $event)
        <div class="card">
            <div class="flex">
                <div>
                    <div class="font-bold text-xl mb-2">
                        Event Configuration
                    </div>

                    <div>
                        @if($event->registrationOptions->isEmpty())
                            No event registration options configured.
                        @else
                            <ul class="list-disc ml-6">
                                @foreach($event->registrationOptions as $option)
                                    <li>
                                        (config#{{ $option->id }} with priority {{ $option->priority }}) Users
                                        @if($option->groupRequirements->isNotEmpty())
                                            in groups [
                                            @foreach($option->groupRequirements as $group)
                                                <a href="{{ route('groups.show', $group) }}" class="hover:underline"><span class="font-bold">{{ $group->name }}</span> (ID {{ $group->id }})</a>{{ $loop->last ? '' : ';' }}
                                            @endforeach
                                            ]
                                        @endif
                                        are able to register between {{ \App\Utils\Date::format($option->opens_at) }} and {{ \App\Utils\Date::format($option->closes_at) }}. They have waitlist priority of {{ $option->waitlist_priority }}.
                                        @if(!$option->count_to_slots)
                                            They do not count towards the slot limit.
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        {{ json_encode($event->registrations) }}
    </div>
@endsection
