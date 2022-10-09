<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\RequestFilters;

use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Core\Requests\RequestFilter;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class EventsReadRequestFilter extends RequestFilter
{
    public const FIELD_VALID_FROM = Events::ATTR_VALID_FROM;

    public const FIELD_VALID_TO = Events::ATTR_VALID_TO;

    /**
     * EventsRequestFilter constructor.
     */
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function getValidatedData(Request $request): array
    {
        return $this->validate($request);
    }

    /**
     * Check if request is valid.

     * @throws ValidationException
     */
    public function validate(Request $request): array
    {
        $validator = $this->getValidator($request);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function getValidator(Request $request): Validator
    {
        return $this->factory->make($request->all(), $this->getRules($request));
    }

    private function getRules(Request $request): array
    {
        return [
            self::FIELD_VALID_FROM => [
                'sometimes',
                'date',
            ],
            self::FIELD_VALID_TO => [
                'sometimes',
                'date',
            ],
        ];
    }
}
