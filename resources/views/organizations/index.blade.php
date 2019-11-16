@extends('layouts.master')

@section('title', 'All organizations')

@section('content')
    @foreach($organizations as $organization)
        <div class="card">
            <a href="{{ route('organizations.show', $organization) }}" class="group">
                <div class="flex">
                    <div class="py-1 pr-4 flex-none">
                        <img src="{{ $organization->imageUrl('avatar') }}" alt="{{ $organization->name }}" class="h-12 w-12 rounded-lg"/>
                    </div>

                    <div>
                        <div class="font-bold text-xl mb-2 group-hover:underline">
                            {{ $organization->name }}
                        </div>

                        <p class="text-gray-700 text-base">
                            {{ $organization->bio }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endsection
