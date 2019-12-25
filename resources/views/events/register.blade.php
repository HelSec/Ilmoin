@extends('layouts.master')

@section('title', 'Attend ' . $event->name)
@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="font-semibold text-2xl mb-2">
                    You're about to register to <a href="{{ route('events.show', $event) }}" class="font-bold hover:underline">{{ $event->name }}</a>
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
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('events.register', $event) }}" method="post">
            @csrf
            <button type="submit" class="button-pink">
                Register {{ $confirmed ? '' : ' to waitlist' }}
            </button>
        </form>
    </div>
@endsection
