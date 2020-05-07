@extends('layouts.master')

@section('title', 'Invite members to group')

@section('content')
    <form class="card" action="{{ route('admin.group.invites.store') }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Invite members to group
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field element="div" title="Group" description="The group to invite people to" class="mt-4">
            <select class="form-select w-full" name="group_id" required>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id', Request::input('group')) == $group->id ? 'selected' : '' }}>
                        {{ $group->name }} in organization {{ $group->organization->name }} (ID {{ $group->id }})
                    </option>
                @endforeach
            </select>
        </x-forms.field>

        <x-forms.field title="User e-mails" description="E-mails of users you want to invite to your group" class="mt-4">
            <x-forms.input-textarea name="users" :value="old('users')"/>
        </x-forms.field>

        <x-forms.field element="div" title="Create invites" description="Saves the invites." class="mt-4">
            <button type="submit" class="button-pink">Invite</button>
        </x-forms.field>
    </form>
@endsection
