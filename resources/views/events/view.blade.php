@extends('layouts.master')

@section('title', $event->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div class="w-full">
                <div class="md:flex md:justify-between w-full">
                    <div class="font-bold text-2xl mb-2">
                        {{ $event->name }}
                    </div>

                    <div>
                        @auth
                            @can('manage', $event)
                                <a href="{{ route('admin.events.edit', $event) }}" class="button-pink mr-2">
                                    Edit event
                                </a>
                            @endcan

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

                <div class="md:flex my-2">
                    <div class="text-gray-700 mr-4">
                        <i class="fas fa-calendar"></i>
                        {{ \App\Utils\Date::format($event->date) }}
                    </div>

                    <div class="text-gray-700 mr-4">
                        <i class="fas fa-location-arrow"></i>
                        {{ $event->location }}
                    </div>

                    @if($event->max_slots !== null)
                        <div class="text-gray-700">
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

    <div class="card">
        <div class="font-bold text-xl mb-2">
            Attendees ({{ $event->registrations->count() }})
        </div>

        <div>
            <x-lists.user-list :users="$event->registrations->pluck('user')"/>
        </div>
    </div>
@endsection
