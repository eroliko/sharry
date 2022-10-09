<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Queries;

use App\Http\Containers\NewsContainer\Contracts\NewsQueryInterface;
use App\Http\Containers\NewsContainer\Models\News;
use App\Http\Core\Queries\QueryBuilder;
use Illuminate\Support\Carbon;

final class NewsQueryBuilder extends QueryBuilder implements NewsQueryInterface
{
    /**
     * Sets correct model
     */
    public function __construct()
    {
        $model = new News();
        $model->registerGlobalScopes($this);
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function whereNewsId(int $id): NewsQueryInterface
    {
        return $this->where(News::ATTR_ID, '=', $id);
    }

    public function whereTitle(string $title): NewsQueryInterface
    {
        return $this
            ->where(News::ATTR_TITLE, '=', $title)
        ;
    }

    public function whereContent(string $content): NewsQueryInterface
    {
        return $this
            ->where(News::ATTR_CONTENT, '=', $content)
        ;
    }

    public function whereToday(): NewsQueryInterface
    {
        return $this
            ->whereDate(News::ATTR_CREATED_AT, '=', new Carbon());
    }

    public function whereIdWithComments(int $id): NewsQueryInterface
    {
        return $this
            ->where(News::ATTR_ID, '=', $id)
            ->with(News::RELATION_COMMENTS)
        ;
    }
}
