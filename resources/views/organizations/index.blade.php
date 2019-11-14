@extends('layouts.master')

@section('content')
    @foreach($organizations as $organization)
        <div class="card">
            <a href="{{ route('organizations.show', $organization) }}" class="group">
                <div class="font-bold text-xl mb-2 group-hover:underline">
                    {{ $organization->name }}
                </div>

                <p class="text-gray-700 text-base">
                    {{ $organization->bio }}
                </p>
            </a>
        </div>
    @endforeach
@endsection
