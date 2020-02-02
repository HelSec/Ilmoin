@extends('layouts.master')

@section('title', 'Create event')

@section('content')
    <div class="card">
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Create event
                    </div>
                </div>
            </div>
        </div>

        <label class="mt-6 block md:flex">
            <div class="md:w-1/3">
                <div class="font-semibold text-black mb-2">Organization</div>
                <div class="text-gray-700 text-sm">Organization hosting the event</div>
            </div>

            <div class="flex-grow">
                <select class="form-select w-full" name="organization_id" required>
                    @foreach($organizations as $organization)
                        <option name="{{ $organization->id }}" {{ old('organization_id') === $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }} (ID {{ $organization->id }})
                        </option>
                    @endforeach
                </select>
            </div>
        </label>
    </div>
@endsection
