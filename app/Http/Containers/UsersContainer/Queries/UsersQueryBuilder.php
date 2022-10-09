<?php

declare(strict_types=1);

namespace App\Http\Containers\UsersContainer\Queries;

use App\Http\Containers\UsersContainer\Contracts\UsersQueryInterface;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Queries\QueryBuilder;

final class UsersQueryBuilder extends QueryBuilder implements UsersQueryInterface
{
    /**
     * Sets correct model
     */
    public function __construct()
    {
        $model = new User();
        $model->registerGlobalScopes($this);
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function whereUsersId(int $id): UsersQueryInterface
    {
        return $this->where(User::ATTR_ID, '=', $id);
    }

    public function whereName(string $name): UsersQueryInterface
    {
        return $this->where(User::ATTR_NAME, '=', $name);
    }

    public function whereEmail(string $email): UsersQueryInterface
    {
        return $this->where(User::ATTR_EMAIL, '=', $email);
    }
}
