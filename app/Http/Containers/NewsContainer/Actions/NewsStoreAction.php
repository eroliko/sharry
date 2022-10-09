<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Actions;

use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Containers\NewsContainer\RequestFilters\NewsRequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsStoreAction extends NewsAction
{
    public function __construct(
        private readonly NewsRequestFilter $newsRequestFilter,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function run(Request $request): News
    {
        $data = $this->newsRequestFilter->getValidatedData($request);

        $new = $this->newsRepository->create($data);
        $new->users()->attach($request->user());

        return $new;
    }
}
