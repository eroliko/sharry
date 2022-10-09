<?php

declare(strict_types=1);

namespace App\Http\Containers\PaginationContainer;

use App\Http\Core\Paginator\PaginationClass;
use App\Http\Core\Paginator\PaginatorDriver;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class PaginationService extends PaginationClass implements PaginatorDriver
{
    public function run(
        Builder $queryBuilder,
        Request $request,
        int|bool $limit = false
    ): LengthAwarePaginator
    {
        if ($limit) {
            $pageItems = !empty($request->input('limit')) ? ((int)$request->input('limit')) : $limit;
        } else {
            $pageItems =
                !empty($request->input('limit')) ?
                    ((int)$request->input('limit'))
                    : env('PAGINATION_LIMIT')
            ;
        }

        $page = !empty($request->input('page')) ? ((int)$request->input('page')) : 1;

        return $queryBuilder->paginate(
            $pageItems,
            page: $page
        );
    }
}
