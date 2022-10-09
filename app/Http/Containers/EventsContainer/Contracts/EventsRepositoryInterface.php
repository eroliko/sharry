<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Contracts;

use App\Http\Containers\EventsContainer\Models\Events;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface EventsRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function get(int $id): Events;

    public function getAll(): Collection;

    public function create(array $data): Events;

    public function save(Events $transaction): void;

    public function delete(Events $transaction): void;

    public function query(): EventsQueryInterface;

    public function update(array $data, Events $event): void;
}
