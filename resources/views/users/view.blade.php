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

    @if($user->activeBlock)
        <div class="card">
            <div>
                This account is blocked.
                @if($user->activeBlock->expires_at)
                    <div class="ml-2">
                        The block expires at {{ \App\Utils\Date::format($user->activeBlock->expires_at) }}.
                    </div>
                @endif
                @if(!empty($user->activeBlock->public_reason))
                    <div class="ml-2">
                        The blocking administrator left the following comment: <span class="font-semibold">{{ $user->activeBlock->public_reason }}</span>
                    </div>
                @endif
                @can('viewPrivateReason', $user->activeBlock)
                    @if(!empty($user->activeBlock->private_reason))
                        <div class="ml-2">
                            The private reason for this block is: <span class="font-semibold">{{ $user->activeBlock->private_reason }}</span>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    @endif
@endsection
