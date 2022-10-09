<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Queries;

use App\Http\Containers\CommentsContainer\Contracts\CommentsQueryInterface;
use App\Http\Containers\CommentsContainer\Models\Comments;
use App\Http\Core\Queries\QueryBuilder;

final class CommentsQueryBuilder extends QueryBuilder implements CommentsQueryInterface
{
    /**
     * Sets correct model
     */
    public function __construct()
    {
        $model = new Comments();
        $model->registerGlobalScopes($this);
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function whereCommentsId(int $id): CommentsQueryInterface
    {
        return $this->where(Comments::ATTR_ID, '=', $id);
    }
}
