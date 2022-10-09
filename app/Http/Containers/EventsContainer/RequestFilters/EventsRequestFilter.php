<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\RequestFilters;

use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Core\Requests\RequestFilter;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class EventsRequestFilter extends RequestFilter
{
    public const FIELD_TITLE = Events::ATTR_TITLE;

    public const FIELD_CONTENT = Events::ATTR_CONTENT;

    public const FIELD_VALID_FROM = Events::ATTR_VALID_FROM;

    public const FIELD_VALID_TO = Events::ATTR_VALID_TO;

    public const FIELD_GPS_LAT = Events::ATTR_GPS_LAT;

    public const FIELD_GPS_LNG = Events::ATTR_GPS_LNG;

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

    private function getValidator(Request $request): Validator
    {
        return $this->factory->make($request->all(), $this->getRules($request));
    }

    private function getRules(Request $request): array
    {
        $isPatch = $request->isMethod('PATCH');
        $required = $isPatch ? 'sometimes' : 'required';

        return [
            self::FIELD_TITLE => [
                $required,
                'string',
                'max: ' . Events::LIMIT_TITLE,
            ],
            self::FIELD_CONTENT => [
                $required,
                'string',
                'max: ' . Events::LIMIT_CONTENT,
            ],
            self::FIELD_VALID_FROM => [
                $required,
                'date',
            ],
            self::FIELD_VALID_TO => [
                $required,
                'date',
            ],
            self::FIELD_GPS_LAT => [
                $required,
                'string',
                'max: ' . Events::LIMIT_GPS,
            ],
            self::FIELD_GPS_LNG => [
                $required,
                'string',
                'max: ' . Events::LIMIT_GPS,
            ],
        ];
    }
}
