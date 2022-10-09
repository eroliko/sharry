<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Contracts;

use App\Http\Core\Contracts\QueryBuilderInterface;

interface NewsQueryInterface extends QueryBuilderInterface
{
    /**
     * Filter by ID
     */
    public function whereNewsId(int $id): self;

    public function whereTitle(string $title): self;

    public function whereContent(string $content): self;
}
