<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Contracts;

use App\Http\Core\Contracts\QueryBuilderInterface;

interface CommentsQueryInterface extends QueryBuilderInterface
{
    /**
     * Filter by ID
     */
    public function whereCommentsId(int $id): self;
}
