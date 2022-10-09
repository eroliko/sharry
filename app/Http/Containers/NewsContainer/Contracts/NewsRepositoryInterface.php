<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Contracts;

use App\Http\Containers\NewsContainer\Models\News;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function get(int $id): News;

    public function getAll(): Collection;

    public function create(array $data): News;

    public function save(News $transaction): void;

    public function delete(News $transaction): void;

    public function query(): NewsQueryInterface;

    public function update(array $data, News $new): void;
}
