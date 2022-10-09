<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Actions;

use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\EventsContainer\RequestFilters\EventsRequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventsStoreAction extends EventsAction
{
    public function __construct(
        private readonly EventsRequestFilter $eventsRequestFilter,
        private readonly EventsRepositoryInterface $eventsRepository,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function run(Request $request): Events
    {
        $data = $this->eventsRequestFilter->getValidatedData($request);

        $event = $this->eventsRepository->create($data);
        $event->users()->attach($request->user());

        return $event;
    }
}
