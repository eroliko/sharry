<?php

declare(strict_types=1);

namespace App\Http\Core\Queries;

use App\Http\Containers\CastTypeEnums\GeneralVarsCastEnums;
use App\Http\Core\Contracts\QueryBuilderInterface;
use App\Http\Core\Helpers\QueryUtils;
use App\Http\Core\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as FrameworkQueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

class QueryBuilder extends Builder implements QueryBuilderInterface
{
    /**
     * @var string[]
     */
    private array $uniqueJoins = [];

    /**
     * @var int
     */
    private static int $joinCounter = 0;

    /**
     * @var bool
     */
    private bool $allSelected = false;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(\Illuminate\Database\Eloquent\Model $model)
    {
        $connection = $model->getConnection();
        $query = new FrameworkQueryBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );

        parent::__construct($query);

        $model->registerGlobalScopes($this);
        $this->setModel($model);
    }

    /**
     * @inheritDoc
     */
    public function makeClone(): static
    {
        return clone $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection
    {
        return $this->get()->toBase();
    }

    /**
     * @inheritDoc
     */
    public function getById(int | string $id): Model
    {
        /** @var Model $model */
        $model = $this->findOrFail($id);
        return $model;
    }

    /** @inheritDoc */
    public function getFirstOrCreate(int | string $id, array $columns): Model
    {
        /** @var Model $model */
        $model = $this->findOrNew($id, $columns);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $ids): Collection
    {
        return $this->findMany($ids);
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): Collection
    {
        return $this->findOrFail($ids);
    }

    /**
     * @inheritDoc
     */
    public function getFirst(): ?Model
    {
        /** @var Model|null $model */
        $model = $this->first();
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function getFirstOrFail(): Model
    {
        /** @var Model $model */
        $model = $this->firstOrFail();
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function findById(int | string $id): ?Model
    {
        /** @var Model|null $model */
        $model = $this->find($id);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function someExists(): bool
    {
        return $this->exists();
    }

    /**
     * @inheritDoc
     */
    public function anyDoesntExist(): bool
    {
        return $this->doesntExist();
    }

    /**
     * @return int
     */
    public function countDistinct(): int
    {
        return $this->distinct()->count();
    }

    /**
     * @return int
     */
    public function countRows(): int
    {
        return $this->count();
    }

    /**
     * @inheritDoc
     */
    public function wherePrimaryKey(array | int | string | Collection $id): QueryBuilderInterface
    {
        if ($this->getModel()->getKeyType() === GeneralVarsCastEnums::INT) {
            $keyColumn = $this->prefixColumn($this->getModel()->getKeyName());
            \is_array($id)
                ? $this->whereIntegerInRaw($keyColumn, $id)
                : $this->where($keyColumn, $id);

            return $this;
        }

        return $this->whereKey($id);
    }

    /**
     * Add a where clause on the bigger primary key to the query.
     *
     * @param int $id
     * @return $this
     */
    public function wherePrimaryKeyGt(int $id): QueryBuilderInterface
    {
        return $this->where($this->model->getQualifiedKeyName(), '>', $id);
    }

    /**
     * Add a where clause on the bigger or equivalent primary key to the query.
     *
     * @param int $id
     * @return $this
     */
    public function wherePrimaryKeyGte(int $id): QueryBuilderInterface
    {
        return $this->where($this->model->getQualifiedKeyName(), '>=', $id);
    }

    /**
     * Add a where clause on the smaller primary key to the query.
     *
     * @param int $id
     * @return $this
     */
    public function wherePrimaryKeyLt(int $id): QueryBuilderInterface
    {
        return $this->where($this->model->getQualifiedKeyName(), '<', $id);
    }

    /**
     * Add a where clause on the smaller or equivalent primary key to the query.
     *
     * @param int $id
     * @return $this
     */
    public function wherePrimaryKeyLte(int $id): QueryBuilderInterface
    {
        return $this->where($this->model->getQualifiedKeyName(), '<=', $id);
    }

    /**
     * @inheritDoc
     */
    public function wherePrimaryKeyNot(array | int | string | Collection $id): QueryBuilderInterface
    {
        return $this->whereKeyNot($id);
    }

    /**
     * @inheritDoc
     */
    public function processChunks(int $size, callable $callback): bool
    {
        return $this->chunk($size, $callback);
    }

    /**
     * @inheritDoc
     */
    public function pluckKeys(): Collection
    {
        return $this->pluck($this->model->getQualifiedKeyName());
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public function quoteColumn(string $column): string
    {
        if ($column !== '*') {
            return \implode('.', \array_map(
                static fn (string $part): string => '`' . \str_replace('`', '\`', $part) . '`',
                \explode('.', $column)
            ));
        }

        return $column;
    }

    /**
     * @inheritDoc
     * @param \Closure|string|string[]|\Illuminate\Database\Query\Expression $column
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and'): Builder | QueryBuilder | static
    {
        if ($column instanceof \Closure) {
            $query = new static($this->getModel());
            $query->withoutGlobalScopes();

            $column($query);

            $this->query->addNestedWhereQuery($query->getQuery(), $boolean);
        } else {
            $this->query->where(...\func_get_args());
        }

        return $this;
    }

    /**
     * Select only rows matching regular expression.
     *
     * @param string $column
     * @param string $regexp
     * @return \App\Http\Core\Queries\QueryBuilder
     */
    public function whereRegexpMatches(string $column, string $regexp): self
    {
        return $this->where($column, 'REGEXP', $regexp);
    }

    /**
     * @inheritDoc
     */
    public function setLimit(int $limit): QueryBuilderInterface
    {
        $this->limit($limit);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setOffset(int $offset): QueryBuilderInterface
    {
        $this->offset($offset);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOnly(string $column): Collection
    {
        return $this->pluck($column);
    }

    /**
     * @inheritDoc
     */
    public function getOnlyKeys(): Collection
    {
        return $this->pluck($this->getModel()->getQualifiedKeyName());
    }

    /**
     * @inheritDoc
     */
    public function ensureNoResults(): self
    {
        $this->whereRaw('0=1');
        return $this;
    }

    /**
     * @param string $relation
     * @param \Closure|null $constrains
     *
     * @return $this
     */
    public function withPossiblyConstrained(string $relation, ?\Closure $constrains): self
    {
        if ($constrains !== null) {
            return $this->with([
                $relation => static function ($relation) use ($constrains): void {
                    $constrains($relation instanceof Relation ? $relation->getQuery() : $relation);
                },
            ]);
        }

        return $this->with($relation);
    }

    /**
     * @param string $relation
     * @param \Closure|null $constrains
     *
     * @param string $operator
     * @param int $count
     * @return $this
     */
    public function whereHasPossiblyConstrained(
        string $relation,
        ?\Closure $constrains,
        string $operator = '>=',
        int $count = 1
    ): self {
        if ($constrains !== null) {
            $this->whereHas(
                $relation,
                static function ($relation) use ($constrains): void {
                    $constrains($relation instanceof Relation ? $relation->getQuery() : $relation);
                },
                $operator,
                $count
            );
        } else {
            $this->whereHas($relation, null, $operator, $count);
        }

        return $this;
    }

    /**
     * Add a "group by" clause to the query.
     *
     * @param array<string|\Illuminate\Database\Query\Expression>|string|\Illuminate\Database\Query\Expression ...$groups
     *
     * @return $this
     */
    public function groupBy(...$groups): self
    {
        $this->getQuery()->groupBy($groups);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function newQueryClone(): self
    {
        return new static($this->getModel());
    }

    /**
     * @inheritDoc
     */
    public function toBaseBuilder(): \Illuminate\Database\Query\Builder
    {
        return $this->toBase();
    }

    /**
     * @inheritDoc
     */
    public function getModelInstance(): Model
    {
        /** @var Model $model */
        $model = $this->getModel();
        return $model;
    }

    /**
     * Get a new instance of the query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function newQuery(): FrameworkQueryBuilder
    {
        return new FrameworkQueryBuilder(
            $this->query->connection,
            $this->query->grammar,
            $this->query->processor
        );
    }

    /**
     * Get a new instance of the current query.
     *
     * @return self
     */
    public function newQueryBuilder(): self
    {
        return new self($this->model);
    }

    /**
     * If join is already used, returns true.
     *
     * @param string $name
     * @param string $joinType
     *
     * @return bool
     */
    protected function checkAndRegisterUniqueJoin(string $name, string $joinType = 'inner'): bool
    {
        $joinId = $joinType . '-' . $name;

        if (isset($this->uniqueJoins[$joinId])) {
            return true;
        }

        $this->uniqueJoins[$joinId] = $this->getUniqueJoinAlias($name, $joinType);
        return false;
    }

    /**
     * Join relation table and make sure it is unique join.
     *
     * @param string $relation
     * @param string $joinType - inner/left/right
     * @param \Closure|null $clause
     *
     * @return string - joined table alias
     */
    protected function uniqueJoinRelation(
        string $relation,
        string $joinType = 'inner',
        ?\Closure $clause = null
    ): string {
        /** @var Model $model */
        $model = $this->getModel();
        $table = $model->getRelationInstance($relation)->getRelated()->getTable();

        if ($this->checkAndRegisterUniqueJoin($table)) {
            return $this->getUniqueJoinAlias($table);
        }

        return $this->joinRelation($relation, $joinType, $clause);
    }

    /**
     * Join relation table.
     *
     * @param string $relation
     * @param string $joinType - inner/left/right
     * @param \Closure|null $clause
     *
     * @return string - joined table alias
     */
    protected function joinRelation(
        string $relation,
        string $joinType = 'inner',
        ?\Closure $clause = null
    ): string {
        /** @var Model $model */
        $model = $this->getModel();
        $relationInstance = $model->getRelationInstance($relation);

        $table = $relationInstance->getRelated()->getTable();

        $alias = $this->getUniqueJoinAlias($table);

        $aliasedTable = $table . ' as ' . $alias;

        $localColumn = null;
        $foreignColumn = null;
        if ($relationInstance instanceof HasOne || $relationInstance instanceof HasMany) {
            $localColumn = $relationInstance->getQualifiedParentKeyName();
            $foreignColumn = $this->prefixColumn($relationInstance->getForeignKeyName(), $alias);
        } elseif ($relationInstance instanceof BelongsTo) {
            $localColumn = $relationInstance->getQualifiedForeignKeyName();
            $foreignColumn = $this->prefixColumn($relationInstance->getOwnerKeyName(), $alias);
        }

        $this->selectAllColumns()
            ->join(
                $aliasedTable,
                static function (
                    JoinClause $join
                ) use ($foreignColumn, $localColumn, $alias, $clause, $table): void {
                    $join->on($localColumn, '=', $foreignColumn);

                    if ($clause) {
                        $clause($join, $table, $alias);
                    }
                },
                $joinType
            );

        return $alias;
    }

    /**
     * If join is already used, returns true.
     *
     * @param string $name
     * @param string $joinType
     *
     * @return string
     */
    protected function getUniqueJoinAlias(string $name, string $joinType = 'inner'): string
    {
        $joinId = $joinType . '-' . $name;
        ++static::$joinCounter;
        return $this->uniqueJoins[$joinId] ?? $name . '_join' . static::$joinCounter;
    }

    /**
     * Select all columns and make sure this select is unique.
     *
     * @return $this
     */
    protected function selectAllColumns(): self
    {
        if ($this->allSelected) {
            return $this;
        }

        $this->allSelected = true;
        $this->addSelect($this->prefixColumn('*'));
        return $this;
    }

    /**
     * Prefix column.
     *
     * @param string $column
     * @param string|null $table
     *
     * @return string
     */
    protected function prefixColumn(string $column, ?string $table = null): string
    {
        return QueryUtils::prefixColumn($column, $table ?? $this->model->getTable());
    }

    /**
     * @inheritDoc
     * @param class-string[] $models
     * @return Model[]
     * @throws \ReflectionException
     */
    protected function eagerLoadRelation(array $models, $name, \Closure $constraints): array
    {
        // First we will "back up" the existing where conditions on the query, so we can
        // add our eager constraints. Then we will merge the wheres that were on the
        // query back to it in order that anywhere conditions might be specified.
        $relation = $this->getRelation($name);

        $relation->addEagerConstraints($models);

        $reflection = new \ReflectionFunction($constraints);
        $reflectionParameter = $reflection->getParameters()[0] ?? null;

        if ($reflectionParameter
            && $reflectionParameter->getType() instanceof \ReflectionNamedType
            && \is_subclass_of($reflectionParameter->getType()->getName(), QueryBuilderInterface::class)
        ) {
            $constraints($relation->getQuery());
        } else {
            $constraints($relation);
        }

        // Once we have the results, we just match those back up to their parent models
        // using the relationship instance. Then we just return the finished arrays
        // of models which have been eagerly hydrated and are readied for return.
        return $relation->match(
            $relation->initRelation($models, $name),
            $relation->getEager(),
            $name
        );
    }

    /**
     * Join same table.
     *
     * @param \Closure $joinClause
     *
     * @return string - table alias
     */
    protected function leftJoinSelf(\Closure $joinClause): string
    {
        $table = $this->getModel()->getTable();

        if ($this->checkAndRegisterUniqueJoin($table, 'left')) {
            return $this->getUniqueJoinAlias($table, 'left');
        }

        $alias = $this->getUniqueJoinAlias($table, 'left');

        $aliasedTable = $table . ' as ' . $alias;

        $this->selectAllColumns()
            ->leftJoin($aliasedTable, static function (JoinClause $clause) use ($alias, $joinClause, $table): void {
                $joinClause($clause, $table, $alias);
            });

        return $alias;
    }

    /**
     * @param string $table
     * @param string|null $as
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function makeSubForTable(string $table, ?string $as = null): FrameworkQueryBuilder
    {
        return $this->newQuery()->from($table, $as);
    }
}
