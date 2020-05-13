<div class="space-y-2">
    @foreach($users as $user)
        <div>
            <div class="font-semibold text-black">
                {{ $user->name }}
            </div>

            <div class="text-sm text-gray-700">
                @if($user->is_super_admin)
                    Ilmoin Administrator
                    &middot;
                @endif
                ID #{{ $user->id }}
                @if($user->real_name)
                    &middot;
                    {{ $user->real_name }}
                @endif
            </div>
        </div>
    @endforeach
</div>
