<?php

namespace App\Policies\Organizations;

use App\Organizations\Events\Event;
use App\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Event $event)
    {
        return $user->can('manage', $event->organization);
    }

    public function attend(User $user, Event $event)
    {
        return $event->getRegistrationOption($user) !== null && $event->registrations()->where('user_id', $user->id)->doesntExist();
    }

    public function cancel(User $user, Event $event)
    {
        return $event->registrations()->where('user_id', $user->id)->exists();
    }
}
