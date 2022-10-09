<?php

declare(strict_types=1);

namespace App\Http\Containers\UsersContainer\Repositories;

use App\Http\Containers\UsersContainer\Contracts\UsersRepositoryInterface;
use App\Http\Containers\UsersContainer\Contracts\UsersQueryInterface;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Containers\UsersContainer\Queries\UsersQueryBuilder;
use Illuminate\Support\Collection;

final class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): User
    {
        /** @var User $transaction */
        $transaction = $this->query()->getById($id);
        return $transaction;
    }

    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    public function create(array $data): User
    {
        $transaction = new User();
        $transaction->compactFill($data);
        $this->save($transaction);

        return $transaction;
    }

    public function save(User $transaction): void
    {
        $transaction->save();
    }

    public function delete(User $transaction): void
    {
        $transaction->delete();
    }

    public function query(): UsersQueryInterface
    {
        return new UsersQueryBuilder();
    }

    public function update(array $data, User $class): void
    {
        $class->update($data);
    }
}
