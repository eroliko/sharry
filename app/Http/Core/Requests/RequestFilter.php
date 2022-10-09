<?php

declare(strict_types=1);

namespace App\Http\Core\Requests;

use Illuminate\Http\Request;

abstract class RequestFilter
{
    /**
     * Get attribute from input / model.
     */
    protected function getFieldValue(string $field, Request $request, callable $fallback): mixed
    {
        if ($request->isMethod('PATCH') && !$request->has($field)) {
            return $fallback();
        }

        return $request->post($field);
    }

    protected function getSometimesRequiredRule(Request $request): string
    {
        return $request->isMethod('PATCH') ? 'sometimes' : 'required';
    }

    /**
     * For PATCH method returns 'sometimes', otherwise 'present'.
     */
    protected function getSometimesPresentRule(Request $request): string
    {
        return $request->isMethod('PATCH') ? 'sometimes' : 'present';
    }
}
