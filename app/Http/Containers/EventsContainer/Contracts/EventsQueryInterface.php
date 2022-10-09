<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Contracts;

use App\Http\Core\Contracts\QueryBuilderInterface;
use Illuminate\Support\Carbon;

interface EventsQueryInterface extends QueryBuilderInterface
{
    /**
     * Filter by ID
     */
    public function whereEventsId(int $id): self;

    public function whereTitle(string $title): self;

    public function whereContent(string $content): self;

    public function whereDatesBetween(?Carbon $validFrom, ?Carbon $validTo): self;
}
