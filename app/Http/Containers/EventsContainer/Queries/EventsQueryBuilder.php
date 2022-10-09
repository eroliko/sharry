<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Queries;

use App\Http\Containers\EventsContainer\Contracts\EventsQueryInterface;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Core\Queries\QueryBuilder;
use Illuminate\Support\Carbon;

final class EventsQueryBuilder extends QueryBuilder implements EventsQueryInterface
{
    /**
     * Sets correct model
     */
    public function __construct()
    {
        $model = new Events();
        $model->registerGlobalScopes($this);
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function whereEventsId(int $id): EventsQueryInterface
    {
        return $this->where(Events::ATTR_ID, '=', $id);
    }

    public function whereTitle(string $title): EventsQueryInterface
    {
        return $this
            ->where(Events::ATTR_TITLE, '=', $title)
        ;
    }

    public function whereContent(string $content): EventsQueryInterface
    {
        return $this
            ->where(Events::ATTR_CONTENT, '=', $content)
        ;
    }

    public function whereDatesBetween(?Carbon $validFrom, ?Carbon $validTo): EventsQueryInterface
    {
        return $this
            ->whereBetween(Events::ATTR_VALID_FROM, [$validFrom, $validTo])
            ->orWhereBetween(Events::ATTR_VALID_TO, [$validFrom, $validTo])
        ;
    }
}
