@extends('layouts.master')

@section('title', 'Edit organization' . $organization->name)

@section('content')
    <a href="{{ route('organizations.show', $organization) }}" class="font-bold text-blue-700 hover:underline">
        « Go Back
    </a>

    <form class="card" action="{{ route('admin.organizations.update', $organization) }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Edit organization {{ $organization->name }}
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field title="Name" description="The name of the organization">
            <x-forms.input-text name="name" :value="old('name', $organization->name)"/>
        </x-forms.field>

        <x-forms.field title="Short bio" description="Short description of this organization" class="mt-4">
            <x-forms.input-textarea name="bio" :value="old('bio', $organization->bio)"/>
        </x-forms.field>

        <x-forms.field title="Description" description="Long description of this organization" class="mt-4">
            <x-forms.input-textarea name="description" :value="old('description', $organization->description)"/>
        </x-forms.field>

        <x-forms.field element="div" title="Save" description="Saves the organization in the database." class="mt-4">
            <button type="submit" class="button-pink">Save</button>
        </x-forms.field>
    </form>

    <x-activity.activity :model="$organization"/>
@endsection
