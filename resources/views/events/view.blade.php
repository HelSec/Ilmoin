@extends('layouts.master')

@section('title', $event->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="font-bold text-2xl mb-2">
                    {{ $event->name }}
                </div>

                <div class="text-gray-800 my-2">
                    Hosted by <a href="{{ route('organizations.show', $event->organization) }}" class="text-black hover:underline">{{ $event->organization->name }}</a>.
                </div>

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

                <div class="text-gray-700 text-base">
                    @parsedown($event->description)
                </div>
            </div>
        </div>
    </div>
@endsection
