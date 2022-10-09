<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Actions;

use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Actions\Action;
use Illuminate\Validation\UnauthorizedException;

class NewsAction extends Action
{
    /** @throws UnauthorizedException */
    protected function canAccess(User $user, News $new): void
    {
        $fail = true;

        foreach ($new->getUsers() as $newUser) {
            if ($user->getKey() === $newUser->getKey()) {
                $fail = false;
                break;
            }
        }

        if ($fail) {
            throw new UnauthorizedException();
        }
    }
}
