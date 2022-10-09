<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Actions;

use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Actions\Action;
use Illuminate\Validation\UnauthorizedException;

class EventsAction extends Action
{
    /** @throws UnauthorizedException */
    protected function canAccess(User $user, Events $event): void
    {
        $fail = true;

        foreach ($event->getUsers() as $eventUser) {
            if ($user->getKey() === $eventUser->getKey()) {
                $fail = false;
                break;
            }
        }

        if ($fail) {
            throw new UnauthorizedException();
        }
    }
}
