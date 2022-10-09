<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Actions;

use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\EventsContainer\RequestFilters\EventsReadRequestFilter;
use App\Http\Containers\PaginationContainer\PaginationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class EventsReadAction extends EventsAction
{
    public function __construct(
        private readonly EventsReadRequestFilter $eventsReadRequestFilter,
        private readonly EventsRepositoryInterface $eventsRepository,
        private readonly PaginationService $paginationService,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function run(Request $request): LengthAwarePaginator
    {
        $data = $this->eventsReadRequestFilter->getValidatedData($request);

        $validFrom =
            empty($data[EventsReadRequestFilter::FIELD_VALID_FROM]) ?
                null
                : new Carbon($data[EventsReadRequestFilter::FIELD_VALID_FROM])
        ;

        $validTo =
            empty($data[EventsReadRequestFilter::FIELD_VALID_TO]) ?
                null
                : new Carbon($data[EventsReadRequestFilter::FIELD_VALID_TO])
        ;


        return $this->paginationService->run(
            $this->eventsRepository->query()->whereDatesBetween(
                $validFrom,
                $validTo,
            ),
            $request
        );
    }
}
