<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Actions;

use App\Http\Containers\CommentsContainer\Contracts\CommentsRepositoryInterface;
use App\Http\Containers\CommentsContainer\Models\Comments;
use App\Http\Containers\CommentsContainer\RequestFilters\CommentsRequestFilter;
use App\Http\Containers\CommentsContainer\Services\CommentEmailService;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Core\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentsStoreAction extends Action
{
    public function __construct(
        private readonly CommentsRequestFilter $commentsRequestFilter,
        private readonly CommentsRepositoryInterface $commentsRepository,
        private readonly CommentEmailService $commentEmailService,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function run(Request $request, News|Events $model): Comments
    {
        $data = $this->commentsRequestFilter->getValidatedData($request);

        $comment = $this->commentsRepository->create($data);

        $model->comments()->attach($comment);

        $this->commentEmailService->sendEmail($model, $comment);

        return $comment;
    }
}
