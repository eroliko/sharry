<?php

declare(strict_types=1);

namespace App\Http\Containers\AuthenticationsContainer\Controllers;

use App\Http\Containers\AuthenticationsContainer\Actions\AuthenticateAction;
use App\Http\Core\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticationsController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function authenticate(
        Request $request,
        AuthenticateAction $authenticateAction,
    ): JsonResponse
    {
        $user = $authenticateAction->run($request);

        return response()->json([
            'token' => $user->createToken($request->header('User-Agent'))->plainTextToken
        ]);
    }
}
