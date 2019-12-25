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
            </div>
        </div>
    </div>
@endsection
