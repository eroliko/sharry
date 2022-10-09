<?php

declare(strict_types=1);

namespace App\Http\Core\Paginator;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

interface PaginatorDriver
{
    public function run(Builder $queryBuilder, Request $request, int|bool $limit = false): LengthAwarePaginator;
}
