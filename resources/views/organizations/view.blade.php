@extends('layouts.master')

@section('title', $organization->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div class="py-1 pr-4 flex-none">
                <img src="{{ $organization->imageUrl('avatar') }}" alt="{{ $organization->name }}" class="h-16 w-16 rounded-lg"/>
            </div>

            <div>
                <div class="font-bold text-2xl mb-2">
                    {{ $organization->name }}
                </div>

                <div class="text-gray-700 text-base">
                    @parsedown($organization->description)
                </div>
            </div>
        </div>
    </div>

    @if($organization->upcomingEvents->isNotEmpty())
        <div class="mt-6">
            <div class="font-bold text-xl mb-2">
                Upcoming events
            </div>

            @foreach($organization->upcomingEvents as $event)
                <div class="card">
                    <div class="flex">
                        <div>
                            <a class="font-bold text-2xl mb-2 hover:underline" href="{{ route('events.show', $event) }}">
                                {{ $event->name }}
                            </a>

                            <div class="flex my-2">
                                <div class="text-gray-700 mr-4">
                                    <i class="fas fa-calendar"></i>
                                    {{ \App\Utils\Date::format($event->date) }}
                                </div>

                                <div class="text-gray-700">
                                    <i class="fas fa-location-arrow"></i>
                                    {{ $event->location }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-gray-700 text-base h-8 overflow-hidden">
                                    @parsedown($event->description)
                                </div>
                            </div>

                            <a href="{{ route('events.show', $event) }}" class="button-pink">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($organization->pastEvents->isNotEmpty())
        <div class="mt-6">
            <div class="font-bold text-xl mb-2">
                Past events
            </div>

            @foreach($organization->pastEvents as $event)
                <div class="card">
                    <div class="flex">
                        <div>
                            <a class="font-bold text-2xl mb-2 hover:underline" href="{{ route('events.show', $event) }}">
                                {{ $event->name }}
                            </a>

                            <div class="flex my-2">
                                <div class="text-gray-700 mr-4">
                                    <i class="fas fa-calendar"></i>
                                    {{ \App\Utils\Date::format($event->date) }}
                                </div>

                                <div class="text-gray-700">
                                    <i class="fas fa-location-arrow"></i>
                                    {{ $event->location }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-gray-700 text-base h-8 overflow-hidden">
                                    @parsedown($event->description)
                                </div>
                            </div>

                            <a href="{{ route('events.show', $event) }}" class="button-pink">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
