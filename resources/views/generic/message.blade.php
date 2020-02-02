@extends('layouts.master')

@section('title', $header)
@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="font-bold text-2xl mb-2">
                    {{ $title }}
                </div>

                <p>
                    {{ $message }}
                </p>

                @if(isset($showLoginMessage) && $showLoginMessage && !Auth::check())
                    <p class="mt-2">
                        Maybe try <a href="{{ route('login') }}" class="text-blue-700 hover:underline">logging in</a>?
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
