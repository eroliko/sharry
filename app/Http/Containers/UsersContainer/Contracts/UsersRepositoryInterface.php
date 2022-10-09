<?php

declare(strict_types=1);

namespace App\Http\Containers\UsersContainer\Contracts;

use App\Http\Containers\UsersContainer\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface UsersRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function get(int $id): User;

    public function getAll(): Collection;

    public function create(array $data): User;

    public function save(User $transaction): void;

    public function delete(User $transaction): void;

    public function query(): UsersQueryInterface;

    public function update(array $data, User $class): void;
}
