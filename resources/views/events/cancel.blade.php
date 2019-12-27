@extends('layouts.master')

@section('title', 'Cancel your registration from ' . $event->name)
@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="font-semibold text-2xl mb-2">
                    You're about cancel of your attendance from <a href="{{ route('events.show', $event) }}" class="font-bold hover:underline">{{ $event->name }}</a>
                </div>

                <div class="text-gray-800 my-2">
                    Hosted by <a href="{{ route('organizations.show', $event->organization) }}" class="text-black hover:underline">{{ $event->organization->name }}</a>. Event page available at <a href="{{ route('events.show', $event) }}" class="font-semibold hover:underline">{{ route('events.show', $event) }}</a>.
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

                {{-- TODO: write some text here explaining stuff about cancelling etc --}}
                <p>
                    Someone should write something about cancelling this and some other stuff and add the text here.
                    For now I am just writing words to make this seem longer for the screenshot. It is currently hard-coded,
                    so we need to make that customizable too.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('events.cancel', $event) }}" method="post">
            @csrf
            <button type="submit" class="button-pink">
                Cancel
            </button>
        </form>
    </div>
@endsection
