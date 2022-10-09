<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Repositories;

use App\Http\Containers\EventsContainer\Contracts\EventsQueryInterface;
use App\Http\Containers\EventsContainer\Contracts\EventsRepositoryInterface;
use App\Http\Containers\EventsContainer\Models\Events;
use App\Http\Containers\EventsContainer\Queries\EventsQueryBuilder;
use Illuminate\Support\Collection;

final class EventsRepository implements EventsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Events
    {
        /** @var Events $transaction */
        $transaction = $this->query()->getById($id);
        return $transaction;
    }

    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    public function create(array $data): Events
    {
        $transaction = new Events();
        $transaction->compactFill($data);
        $this->save($transaction);

        return $transaction;
    }

    public function save(Events $transaction): void
    {
        $transaction->save();
    }

    public function delete(Events $transaction): void
    {
        $transaction->delete();
    }

    public function query(): EventsQueryInterface
    {
        return new EventsQueryBuilder();
    }

    public function update(array $data, Events $event): void
    {
        $event->update($data);
    }
}
