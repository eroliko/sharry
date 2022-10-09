<?php

declare(strict_types=1);

namespace App\Http\Containers\AuthenticationsContainer\RequestFilters;

use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Requests\RequestFilter;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class AuthenticationsRequestFilter extends RequestFilter
{
    public const FIELD_PASSWORD = User::ATTR_PASSWORD;

    public const FIELD_EMAIL = User::ATTR_EMAIL;

    /**
     * UsersRequestFilter constructor.
     */
    public function __construct(
        private readonly Factory $factory,
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
        return [
            self::FIELD_PASSWORD => [
                'required',
                'string',
            ],
            self::FIELD_EMAIL => [
                'required',
                'email',
            ],
        ];
    }
}
