@extends('layouts.master')

@section('title', $user->name)

@section('content')
    <div class="card">
        <div class="flex">
            <div class="w-full">
                <div class="md:flex md:justify-between w-full">
                    <div class="font-bold text-2xl mb-2">
                        {{ $user->name }}
                    </div>

                    <div>
                        @auth
                            <!-- actions here -->
                        @endif
                    </div>
                </div>

                <div class="text-gray-800 my-2">
                    User details here
                </div>
            </div>
        </div>
    </div>
@endsection
