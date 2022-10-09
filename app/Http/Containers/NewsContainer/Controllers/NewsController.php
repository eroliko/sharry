<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Controllers;

use App\Http\Containers\CastTypeEnumsContainer\HttpCodesEnums;
use App\Http\Containers\NewsContainer\Actions\NewsDeleteAction;
use App\Http\Containers\NewsContainer\Actions\NewsStoreAction;
use App\Http\Containers\NewsContainer\Actions\NewsUpdateAction;
use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use App\Http\Containers\PaginationContainer\PaginationService;
use App\Http\Core\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

final class NewsController extends Controller
{
    /**
     * @throws ModelNotFoundException
     * @throws ValidationException
     * @throws UnauthorizedException
     */
    public function update(
        int $id,
        Request $request,
        NewsUpdateAction $newsUpdateAction,
    ): JsonResponse {
        $newsUpdateAction->run($id, $request);

        return response()->json([],HttpCodesEnums::HTTP_UPDATED);
    }

    /**
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function delete(
        int $id,
        Request $request,
        NewsDeleteAction $newsDeleteAction,
    ): JsonResponse {
        $newsDeleteAction->run($id, $request);

        return response()->json([],HttpCodesEnums::HTTP_DELETED);
    }

    /**
     * @throws ValidationException
     */
    public function store(
        Request $request,
        NewsStoreAction $newsStoreAction,
    ): JsonResponse {
        $new = $newsStoreAction->run($request);

        return response()->json($new->toArray(), HttpCodesEnums::HTTP_CREATED);
    }

    /** @throws ModelNotFoundException */
    public function show(int $id, NewsRepositoryInterface $newsRepository): JsonResponse
    {
        return response()->json(
            $newsRepository->get($id)->toArray()
        );
    }

    public function read(
        Request $request,
        PaginationService $paginationService,
        NewsRepositoryInterface $newsRepository,
    ): JsonResponse {
        return response()->json(
            $paginationService->run(
                $newsRepository->query(),
                $request,
            )
        );
    }
}
