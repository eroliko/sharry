<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Actions;

use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class EventsDeleteAction extends EventsAction
{
    public function __construct(
        private readonly EventsRepositoryInterface $eventsRepository,
    ) {
    }

    /**
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function run(int $id, Request $request): void
    {
        $event = $this->eventsRepository->get($id);

        $this->canAccess($request->user(), $event);

        $this->eventsRepository->delete($event);
    }
}
