<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Services;

use App\Http\Containers\CommentsContainer\Models\Comments;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Containers\UsersContainer\Models\User;
use Illuminate\Mail\MailManager;
use Illuminate\Mail\Message;

class CommentEmailService
{
    public function __construct(
        private readonly MailManager $mailManager,
    ) {
    }

    public function sendEmail(News|Events $model, Comments $comment): void
    {
        // There should be only one user by the logic
        /** @var User $user */
        $user = $model->getUsers()->first();
        $this->mailManager->send(
            "comment-email",
            ['name' => $comment->getNickName()],
            static function (Message $message) use($user) {
                $message
                    ->to($user->getEmail())
                    ->subject("New comment")
                ;
            }
        );
    }
}
