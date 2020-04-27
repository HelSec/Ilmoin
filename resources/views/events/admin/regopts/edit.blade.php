@extends('layouts.master')

@section('title', 'Edit event registration option')

@section('content')
    <a href="{{ route('admin.events.edit', $event) }}" class="font-bold text-blue-700 hover:underline">
        « Go Back
    </a>

    <form class="card" action="{{ route('admin.events.regopts.update', $option) }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Edit event registration option
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field title="Event" description="The thing that you're creating the registration option for">
            <x-forms.input-text name="event" disabled :value="$event->name"/>
        </x-forms.field>

        <x-forms.field element="div" title="Enabled" description="" class="mt-4">
            <x-forms.yes-no-buttons name="enabled" :value="old('enabled', $option->enabled)" />
        </x-forms.field>

        <x-forms.field title="Priority" description="Unique in the event. Larger priority options are used first." class="mt-4">
            <x-forms.input-text name="priority" type="number" :value="old('priority', $option->priority)"/>
        </x-forms.field>

        <x-forms.field title="Opens at" description="This option will not be working before this time." class="mt-4">
            <x-forms.input-text name="opens_at" type="datetime_local" :value="old('opens_at', $option->opens_at)"/>
            <x-forms.datetime-local-notice/>
        </x-forms.field>

        <x-forms.field title="Closes at" description="This option will not be working after this time." class="mt-4">
            <x-forms.input-text name="closes_at" type="datetime_local" :value="old('closes_at', $option->closes_at)"/>
            <x-forms.datetime-local-notice/>
        </x-forms.field>

        <x-forms.field title="Waitlist priority" description="Larger values get higher priority when selecting people from waitlist." class="mt-4">
            <x-forms.input-text name="waitlist_priority" type="number" :value="old('waitlist_priority', $option->waitlist_priority)"/>
        </x-forms.field>

        <x-forms.field element="div" title="Count to slots" description="If disabled, people who registered with this option do not count to max slots." class="mt-4">
            <x-forms.yes-no-buttons name="count_to_slots" :value="old('count_to_slots', $option->count_to_slots)" />
        </x-forms.field>

        <x-forms.field element="div" title="Groups" description="Restrict this option to members of the specified groups only. If none are selected, this option is available to everybody." class="mt-4">
            @foreach($event->organization->groups as $group)
                <label class="block">
                    <input type="checkbox" class="form-checkbox" name="groups[]" value="{{ $group->id }}" {{ in_array($group->id, old('groups', $groups)) ? 'checked' : '' }}>
                    {{ $group->name }}
                </label>
            @endforeach
        </x-forms.field>

        <x-forms.field title="Save" description="Creates the registration option." class="mt-4">
            <button type="submit" class="button-pink">Save</button>
        </x-forms.field>
    </form>
@endsection
