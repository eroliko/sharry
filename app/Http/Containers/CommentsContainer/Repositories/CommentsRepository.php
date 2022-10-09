<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Repositories;

use App\Http\Containers\CommentsContainer\Contracts\CommentsQueryInterface;
use App\Http\Containers\CommentsContainer\Contracts\CommentsRepositoryInterface;
use App\Http\Containers\CommentsContainer\Models\Comments;
use App\Http\Containers\CommentsContainer\Queries\CommentsQueryBuilder;
use Illuminate\Support\Collection;

final class CommentsRepository implements CommentsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Comments
    {
        /** @var Comments $transaction */
        $transaction = $this->query()->getById($id);
        return $transaction;
    }

    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    public function create(array $data): Comments
    {
        $transaction = new Comments();
        $transaction->compactFill($data);
        $this->save($transaction);

        return $transaction;
    }

    public function save(Comments $transaction): void
    {
        $transaction->save();
    }

    public function delete(Comments $transaction): void
    {
        $transaction->delete();
    }

    public function query(): CommentsQueryInterface
    {
        return new CommentsQueryBuilder();
    }

    public function update(array $data, Comments $comment): void
    {
        $comment->update($data);
    }
}
