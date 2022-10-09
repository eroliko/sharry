<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Actions;

use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use App\Http\Containers\NewsContainer\RequestFilters\NewsRequestFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class NewsUpdateAction extends NewsAction
{
    public function __construct(
        private readonly NewsRequestFilter $newsRequestFilter,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @throws ValidationException
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function run(int $id, Request $request): void
    {
        $new = $this->newsRepository->get($id);

        $this->canAccess($request->user(), $new);

        $data = $this->newsRequestFilter->getValidatedData($request);

        $this->newsRepository->update($data, $new);
    }
}
