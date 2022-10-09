<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Controllers;

use App\Http\Containers\CastTypeEnumsContainer\HttpCodesEnums;
use App\Http\Containers\EventsContainer\Actions\EventsDeleteAction;
use App\Http\Containers\EventsContainer\Actions\EventsReadAction;
use App\Http\Containers\EventsContainer\Actions\EventsStoreAction;
use App\Http\Containers\EventsContainer\Actions\EventsUpdateAction;
use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use App\Http\Core\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

final class EventsController extends Controller
{
    /**
     * @throws ModelNotFoundException
     * @throws ValidationException
     * @throws UnauthorizedException
     */
    public function update(
        int $id,
        Request $request,
        EventsUpdateAction $eventsUpdateAction,
    ): JsonResponse {
        $eventsUpdateAction->run($id, $request);

        return response()->json([],HttpCodesEnums::HTTP_UPDATED);
    }

    /**
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function delete(
        int $id,
        Request $request,
        EventsDeleteAction $eventsDeleteAction,
    ): JsonResponse {
        $eventsDeleteAction->run($id, $request);

        return response()->json([],HttpCodesEnums::HTTP_DELETED);
    }

    /**
     * @throws ValidationException
     */
    public function store(
        Request $request,
        EventsStoreAction $eventsStoreAction,
    ): JsonResponse {
        $event = $eventsStoreAction->run($request);

        return response()->json($event->toArray(), HttpCodesEnums::HTTP_CREATED);
    }

    /** @throws ModelNotFoundException */
    public function show(int $id, EventsRepositoryInterface $eventsRepository): JsonResponse
    {
        return response()->json(
            $eventsRepository->get($id)->toArray()
        );
    }

    /**
     * @throws ValidationException
     */
    public function read(Request $request, EventsReadAction $readAction): JsonResponse
    {
        return response()->json(
            $readAction->run($request)
        );
    }
}
