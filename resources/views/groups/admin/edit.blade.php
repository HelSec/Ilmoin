@extends('layouts.master')

@section('title', 'Edit group')

@section('content')
    <a href="{{ route('groups.show', $group) }}" class="font-bold text-blue-700 hover:underline">
        « Go Back
    </a>

    <form class="card" action="{{ route('admin.groups.update', $group) }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Edit group
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field title="Name" description="The name of the group">
            <x-forms.input-text name="name" :value="old('name', $group->name)"/>
        </x-forms.field>

        <x-forms.field title="Description" description="Ths" class="mt-4">
            <x-forms.input-textarea name="description" :value="old('description', $group->description)"/>
        </x-forms.field>

        <x-forms.field element="div" title="Is public" description="If enabled, this group will be visible to everyone." class="mt-4">
            <x-forms.yes-no-buttons name="is_public" :value="old('is_public', $group->is_public)" />
        </x-forms.field>

        <x-forms.field element="div" title="Is member list public" description="If enabled, anyone can see the full member list of this group." class="mt-4">
            <x-forms.yes-no-buttons name="is_member_list_public" :value="old('is_member_list_public', $group->is_member_list_public)" />
        </x-forms.field>

        <x-forms.field element="div" title="Is member list shown to other members" description="If enabled, any member can see the full member list of this group." class="mt-4">
            <x-forms.yes-no-buttons name="is_member_list_shown_to_other_members" :value="old('is_member_list_shown_to_other_members', $group->is_member_list_shown_to_other_members)" />
        </x-forms.field>

        <x-forms.field element="div" title="Save" description="Saves all changes to the database." class="mt-4">
            <button type="submit" class="button-pink">Save</button>
        </x-forms.field>
    </form>

    <x-activity.activity :model="$group"/>
@endsection
