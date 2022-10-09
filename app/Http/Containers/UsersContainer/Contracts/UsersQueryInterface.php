<?php

declare(strict_types=1);

namespace App\Http\Containers\UsersContainer\Contracts;

use App\Http\Core\Contracts\QueryBuilderInterface;

interface UsersQueryInterface extends QueryBuilderInterface
{
    /**
     * Filter by ID
     */
    public function whereUsersId(int $id): self;

    public function whereName(string $name): self;

    public function whereEmail(string $email): self;
}
