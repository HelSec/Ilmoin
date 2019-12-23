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

    @if($organization->groups->isNotEmpty())
        <div class="mt-6">
            <div class="font-bold text-xl mb-2">
                Groups ({{ $organization->groups->count() }})
            </div>

            @foreach($organization->groups as $group)
                <div class="card">
                    @can('view', $group)
                        <div class="flex">
                            <div>
                                <div>
                                    <a class="font-bold text-2xl mb-2 hover:underline" href="{{ route('groups.show', $group) }}">
                                        {{ $group->name }}
                                    </a>
                                </div>

                                <div class="flex my-2">
                                    <div class="badge-green">
                                        {{ $group->members->count() }} member(s)
                                    </div>

                                    @if($organization->admin_group_id === $group->id)
                                        <span class="badge-blue ml-2">
                                            Organization administrator
                                        </span>
                                    @endif

                                    @if(!$group->is_public)
                                        <span class="badge-red ml-2">
                                            Private group
                                        </span>
                                    @endif
                                </div>

                                @if($group->description)
                                    <div class="mb-4">
                                        <div class="text-gray-700 text-base h-8 overflow-hidden">
                                            @parsedown($group->description)
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('groups.show', $group) }}" class="button-pink">
                                        Show more
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            This group is hidden from the public view.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
