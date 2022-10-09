<?php

declare(strict_types=1);

namespace App\Http\Containers\AuthenticationsContainer\Actions;

use App\Http\Containers\AuthenticationsContainer\RequestFilters\AuthenticationsRequestFilter;
use App\Http\Containers\UsersContainer\Contracts\UsersRepositoryInterface;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Actions\Action;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticateAction extends Action
{
    public function __construct(
        private readonly HashManager $hashManager,
        private readonly AuthenticationsRequestFilter $authenticationsRequestFilter,
        private readonly UsersRepositoryInterface $usersRepository,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function run(Request $request): User
    {
        $data = $this->authenticationsRequestFilter->getValidatedData($request);

        /** @var ?User $user */
        $user = $this
            ->usersRepository
            ->query()
            ->whereEmail($data[AuthenticationsRequestFilter::FIELD_EMAIL])
            ->getFirst();
        if (
            ! $user
            || ! $this->hashManager->check($data[AuthenticationsRequestFilter::FIELD_PASSWORD], $user->getPassword())
        ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }
}
