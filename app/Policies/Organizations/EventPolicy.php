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
}
