<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Actions;

use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class NewsDeleteAction extends NewsAction
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function run(int $id, Request $request): void
    {
        $new = $this->newsRepository->get($id);

        $this->canAccess($request->user(), $new);

        $this->newsRepository->delete($new);
    }
}
