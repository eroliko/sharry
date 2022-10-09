<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\RequestFilters;

use App\Http\Containers\CommentsContainer\Models\Comments;
use App\Http\Core\Requests\RequestFilter;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class CommentsRequestFilter extends RequestFilter
{
    public const FIELD_NICKNAME= Comments::ATTR_NICKNAME;

    public const FIELD_CONTENT = Comments::ATTR_CONTENT;

    /**
     * CommentsRequestFilter constructor.
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
            self::FIELD_CONTENT => [
                $required,
                'string',
                'max: ' . Comments::LIMIT_CONTENT,
            ],
            self::FIELD_NICKNAME => [
                $required,
                'string',
                'max: ' . Comments::LIMIT_NICKNAME,
            ],
        ];
    }
}
