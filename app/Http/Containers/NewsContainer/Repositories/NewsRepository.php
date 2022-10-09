<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Repositories;

use App\Http\Containers\NewsContainer\Contracts\NewsQueryInterface;
use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Containers\NewsContainer\Queries\NewsQueryBuilder;
use Illuminate\Support\Collection;

final class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): News
    {
        /** @var News $transaction */
        $transaction = $this->query()->getById($id);
        return $transaction;
    }

    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    public function create(array $data): News
    {
        $transaction = new News();
        $transaction->compactFill($data);
        $this->save($transaction);

        return $transaction;
    }

    public function save(News $transaction): void
    {
        $transaction->save();
    }

    public function delete(News $transaction): void
    {
        $transaction->delete();
    }

    public function query(): NewsQueryInterface
    {
        return new NewsQueryBuilder();
    }

    public function update(array $data, News $new): void
    {
        $new->update($data);
    }
}
