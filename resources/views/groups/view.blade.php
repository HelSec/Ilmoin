@extends('layouts.master')

@section('title', $group->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div class="w-full">
                <div class="md:flex md:justify-between w-full">
                    <div class="font-bold text-2xl mb-2">
                        {{ $group->name }}
                    </div>

                    <div>
                        @auth
                            @can('manage', $group)
                                <a href="{{ route('admin.group.invites.create', ['group' => $group->id]) }}" class="button-pink mr-2">
                                    Invite people
                                </a>

                                <a href="{{ route('admin.groups.edit', $group) }}" class="button-pink mr-2">
                                    Edit group
                                </a>
                            @endcan
                            @can('join', $group)
                                <a href="{{ route('groups.join', $group) }}" class="button-pink mr-2">
                                    Join
                                </a>
                            @endcan
                        @endif
                    </div>
                </div>

                <div class="text-gray-800 my-2">
                    A group in the <a href="{{ route('organizations.show', $group->organization) }}" class="text-black hover:underline">{{ $group->organization->name }}</a> organization.
                </div>

                <div class="my-2 flex">
                    <div class="badge-green">
                        {{ $group->members->count() }} member(s)
                    </div>

                    @if($group->organization->admin_group_id === $group->id)
                        <span class="badge-blue ml-2">
                            Organization administrator
                        </span>
                    @endif

                    @if(!$group->is_public)
                        <span class="badge-red ml-2">
                            Private group
                        </span>
                    @endif
                </div>

                <div class="text-gray-700 text-base">
                    @parsedown($group->description)
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="font-bold text-xl mb-2">
            Members ({{ $group->members->count() }})
        </div>

        <div>
            @can('viewMembers', $group)
                {{ json_encode($group->members) }}
            @else
                You may not view the member list of this group.
            @endif
        </div>
    </div>
@endsection
