<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Contracts;

use App\Http\Containers\CommentsContainer\Models\Comments;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface CommentsRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function get(int $id): Comments;

    public function getAll(): Collection;

    public function create(array $data): Comments;

    public function save(Comments $transaction): void;

    public function delete(Comments $transaction): void;

    public function query(): CommentsQueryInterface;

    public function update(array $data, Comments $comment): void;
}
