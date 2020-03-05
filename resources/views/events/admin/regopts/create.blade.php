@extends('layouts.master')

@section('title', 'Create event')

@section('content')
    <a href="{{ route('admin.events.edit', $event) }}" class="font-bold text-blue-700 hover:underline">
        « Go Back
    </a>

    <form class="card" action="{{ route('admin.events.regopts.store', $event) }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Create event registration option
                    </div>
                </div>
            </div>
        </div>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Event</div>
                <div class="text-gray-700 text-sm">The thing that you're creating the registration option for</div>
            </div>

            <div class="md:w-2/3">
                <input type="text" name="event" class="form-input w-full bg-gray-300 cursor-not-allowed" disabled value="{{ $event->name }}">
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Priority</div>
                <div class="text-gray-700 text-sm">Unique in the event. Larger priority options are used first.</div>
            </div>

            <div class="md:w-2/3">
                <input type="number" name="priority" class="form-input w-full" value="{{ old('priority') }}">
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Opens at</div>
                <div class="text-gray-700 text-sm">This option will not be working before this time.</div>
            </div>

            <div class="md:w-2/3">
                <div>
                    <input type="datetime-local" name="opens_at" class="form-input w-full"
                           required value="{{ old('opens_at') }}">
                </div>

                <p class="text-gray-700">
                    If your browser does not support
                    <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/datetime-local" class="text-blue-700 underline hover:no-underline"><code>
                            &lt;input type="datetime-local"&gt;</code></a>,
                    please use format
                    <code>
                        YYYY-MM-DD<span class="text-blue-500">T</span>HH:MM</code>.

                    Current timezone is <span>{{ config('app.timezone') }}</span>.
                </p>
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Closes at</div>
                <div class="text-gray-700 text-sm">This option will not be working before this time.</div>
            </div>

            <div class="md:w-2/3">
                <div>
                    <input type="datetime-local" name="closes_at" class="form-input w-full"
                           required value="{{ old('closes_at') }}">
                </div>

                <p class="text-gray-700">
                    If your browser does not support
                    <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/datetime-local" class="text-blue-700 underline hover:no-underline"><code>
                            &lt;input type="datetime-local"&gt;</code></a>,
                    please use format
                    <code>
                        YYYY-MM-DD<span class="text-blue-500">T</span>HH:MM</code>.

                    Current timezone is <span>{{ config('app.timezone') }}</span>.
                </p>
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Waitlist priority</div>
                <div class="text-gray-700 text-sm">Larger values get higher priority when selecting people from waitlist.</div>
            </div>

            <div class="md:w-2/3">
                <input type="number" name="waitlist_priority" class="form-input w-full" value="{{ old('waitlist_priority') }}">
            </div>
        </label>

        <div class="mt-6 md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Count to slots</div>
                <div class="text-gray-700 text-sm">If no, people who registered with this option do not count to max slots.</div>
            </div>

            <div class="md:w-2/3">
                <label class="block">
                    <input type="radio" class="form-radio" name="count_to_slots" value="1" {{ old('count_to_slots', true) ? 'checked' : '' }}> Yes
                </label>

                <label class="block">
                    <input type="radio" class="form-radio" name="count_to_slots" value="0" {{ !old('count_to_slots', true) ? 'checked' : '' }}> No
                </label>
            </div>
        </div>

        <div class="mt-6 md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Save</div>
                <div class="text-gray-700 text-sm">Creates the registration option</div>
            </div>

            <div class="md:w-2/3">
                <button type="submit" class="button-pink">Save</button>
            </div>
        </div>
    </form>
@endsection
