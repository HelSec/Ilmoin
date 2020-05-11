@extends('layouts.master')

@section('title', 'Create organization')

@section('content')
    <form class="card" action="{{ route('admin.organizations.store') }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Create organization
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field title="Name" description="The name of the organization">
            <x-forms.input-text name="name" :value="old('name')"/>
        </x-forms.field>

        <x-forms.field title="Short bio" description="Short description of this organization" class="mt-4">
            <x-forms.input-textarea name="bio" :value="old('bio')"/>
        </x-forms.field>

        <x-forms.field title="Description" description="Long description of this organization" class="mt-4">
            <x-forms.input-textarea name="description" :value="old('description')"/>
        </x-forms.field>

        <x-forms.field element="div" title="Save" description="Creates the organization in the database." class="mt-4">
            <button type="submit" class="button-pink">Save</button>
        </x-forms.field>
    </form>
@endsection
