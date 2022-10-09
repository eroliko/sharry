<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Contracts;

use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Containers\PaginationContainer\PaginationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
