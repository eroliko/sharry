<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\RequestFilters;

use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Core\Requests\RequestFilter;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class NewsRequestFilter extends RequestFilter
{
    public const FIELD_TITLE = News::ATTR_TITLE;

    public const FIELD_CONTENT = News::ATTR_CONTENT;

    /**
     * NewsRequestFilter constructor.
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
                'max: ' . News::LIMIT_TITLE,
            ],
            self::FIELD_CONTENT => [
                $required,
                'string',
                'max: ' . News::LIMIT_CONTENT,
            ],
        ];
    }
}
