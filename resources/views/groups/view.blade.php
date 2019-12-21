@extends('layouts.master')

@section('title', $group->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="font-bold text-2xl mb-2">
                    {{ $group->name }}
                </div>

                <div class="text-gray-800 my-2">
                    A group in the <a href="{{ route('organizations.show', $group->organization) }}" class="text-black hover:underline">{{ $group->organization->name }}</a> organization.
                </div>

                @if($group->organization->admin_group_id === $group->id)
                    <div class="my-2">
                        <span class="badge-blue">
                            Organization administrator
                        </span>
                    </div>
                @endif

                <div class="text-gray-700 text-base">
                    @parsedown($group->description)
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="font-bold text-xl mb-2">
            Members
        </div>

        <div>
            {{ json_encode($group->members) }}
        </div>
    </div>
@endsection
