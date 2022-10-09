<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Actions;

use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use App\Http\Containers\EventsContainer\RequestFilters\EventsRequestFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class EventsUpdateAction extends EventsAction
{
    public function __construct(
        private readonly EventsRequestFilter $eventsRequestFilter,
        private readonly EventsRepositoryInterface $eventsRepository,
    ) {
    }

    /**
     * @throws ValidationException
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function run(int $id, Request $request): void
    {
        $event = $this->eventsRepository->get($id);

        $this->canAccess($request->user(), $event);

        $data = $this->eventsRequestFilter->getValidatedData($request);

        $this->eventsRepository->update($data, $event);
    }
}
