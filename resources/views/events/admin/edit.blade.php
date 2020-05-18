@extends('layouts.master')

@section('title', 'Edit event')

@section('content')
    <a href="{{ route('events.show', $event) }}" class="font-bold text-blue-700 hover:underline">
        « Go Back
    </a>

    <form class="card" action="{{ route('admin.events.update', $event) }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Edit event
                    </div>
                </div>
            </div>
        </div>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Organization</div>
                <div class="text-gray-700 text-sm">Organization hosting the event</div>
            </div>

            <div class="md:w-2/3">
                <select class="form-select w-full" name="organization_id" required>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" {{ old('organization_id', $event->organization_id) == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }} (ID {{ $organization->id }})
                        </option>
                    @endforeach
                </select>
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Name</div>
                <div class="text-gray-700 text-sm">The primary name of the event</div>
            </div>

            <div class="md:w-2/3">
                <input type="text" name="name" placeholder="KaukanstanSec January 2069 Meetup" class="form-input w-full" required minlength="3" value="{{ old('name', $event->name) }}">
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Description</div>
                <div class="text-gray-700 text-sm">Extended details. Markdown is supported.</div>
            </div>

            <div class="md:w-2/3">
                <textarea name="description" placeholder="Please fill in some unnecessary detail about this event." class="form-textarea w-full" required minlength="3"
                >{{ old('description', $event->description) }}</textarea>
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Date and Time</div>
                <div class="text-gray-700 text-sm">Will be shown at the event details.</div>
            </div>

            <div class="md:w-2/3">
                <div>
                    <input type="datetime-local" name="date" class="form-input w-full"
                           required value="{{ old('date', \App\Utils\Date::fromString($event->date)->tz(config('app.timezone'))->format('Y-m-d\\TH:i')) }}">
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
                <div class="font-semibold text-black mb-2">Location</div>
                <div class="text-gray-700 text-sm">Also will be shown at the event details.</div>
            </div>

            <div class="md:w-2/3">
                <input type="text" name="location" placeholder="SomeCompany HQ" class="form-input w-full" required minlength="1" value="{{ old('location', $event->location) }}">
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Maximum slots</div>
                <div class="text-gray-700 text-sm">Will limit the number of attendees. Not required.</div>
            </div>

            <div class="md:w-2/3">
                <input type="number" name="max_slots" placeholder="123456" class="form-input w-full" value="{{ old('max_slots', $event->max_slots) }}">
            </div>
        </label>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Last cancel date</div>
                <div class="text-gray-700 text-sm">The last date attendees are able to cancel their spot. Not required.</div>
            </div>

            <div class="md:w-2/3">
                <div>
                    <input type="datetime-local" name="last_cancel_date" class="form-input w-full"
                           required value="{{ old('last_cancel_date', \App\Utils\Date::fromString($event->last_cancel_date)->tz(config('app.timezone'))->format('Y-m-d\\TH:i')) }}">
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

        <div class="mt-6 md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Save</div>
                <div class="text-gray-700 text-sm">Updates the event</div>
            </div>

            <div class="md:w-2/3">
                <button type="submit" class="button-pink">Save</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="flex">
            <div class="w-full">
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Registration options
                    </div>

                    <div>
                        <a href="{{ route('admin.events.regopts.create', $event) }}" class="button-pink mr-2">
                            Add
                        </a>
                    </div>
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
                                    @if(!$option->enabled)
                                        This option is disabled.
                                    @endif

                                    [<a href="{{ route('admin.events.regopts.edit', $option) }}" class="hover:underline text-black"
                                        >edit</a>]
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-activity.activity :model="$event"/>
@endsection
