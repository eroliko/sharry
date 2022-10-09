<?php

declare(strict_types=1);

namespace App\Http\Core\Contracts;

use App\Http\Core\Models\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface QueryBuilderInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int | string $id): Model;

    public function findByIds(array $ids): Collection;

    public function getByIds(array $ids): Collection;

    public function getFirst(): ?Model;

    /** @param array<mixed> $columns */
    public function getFirstOrCreate(int | string $id, array $columns): Model;

    /**
     * @throws ModelNotFoundException
     */
    public function getFirstOrFail(): Model;

    public function findById(int | string $id): ?Model;

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function someExists(): bool;

    /**
     * Determine if any rows don't exist for the current query.
     *
     * @return bool
     */
    public function anyDoesntExist(): bool;

    /**
     * Count distinct rows.
     *
     * @return int
     */
    public function countDistinct(): int;

    /**
     * Count rows.
     *
     * @return int
     */
    public function countRows(): int;

    public function wherePrimaryKey(array | int | string | Collection $id): self;

    public function wherePrimaryKeyGt(int $id): self;

    public function wherePrimaryKeyGte(int $id): self;

    public function wherePrimaryKeyLt(int $id): self;

    public function wherePrimaryKeyLte(int $id): self;

    public function wherePrimaryKeyNot(array | int | string | Collection $id): self;

    public function processChunks(int $size, callable $callback): bool;

    public function pluckKeys(): Collection;

    public function setLimit(int $limit): self;

    public function setOffset(int $offset): self;

    public function getOnly(string $column): Collection;

    public function getOnlyKeys(): Collection;

    public function ensureNoResults(): self;

    public function getModelInstance(): Model;

    public function groupBy(...$groups): self;

    public function newQueryClone(): self;

    public function toBaseBuilder(): Builder;

    public function makeClone(): static;
}
