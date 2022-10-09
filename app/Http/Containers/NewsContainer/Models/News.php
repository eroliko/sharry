<?php

declare(strict_types=1);

namespace App\Http\Containers\NewsContainer\Models;

use App\Http\Containers\CastTypeEnumsContainer\GeneralVarsCastEnums;
use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

final class News extends Model
{
    /**
     * Public attributes
     */
    public const ATTR_ID = 'id';

    public const ATTR_TITLE = 'title';

    public const ATTR_CONTENT = 'content';

    public const ATTR_CREATED_AT = parent::CREATED_AT;

    public const ATTR_UPDATED = parent::UPDATED_AT;

    /**
     * Public limits
     */
    public const LIMIT_TITLE = 128;

    public const LIMIT_CONTENT = 2048;

    /**
     * Relations
     */
    public const RELATION_USERS = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        self::ATTR_TITLE,
        self::ATTR_CONTENT,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string>
     */
    protected $casts = [];


    /**
     * The attributes that should be hidden.
     *
     * @var array<string>
     */
    protected $hidden = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'users_news',
            'new_id',
            'user_id',
        );
    }

    /** @return Collection<User> */
    public function getUsers(): Collection
    {
        return $this->getRelationValue(self::RELATION_USERS);
    }

    /**
     * Fill model with compact data.
     *
     * @param array $data
     */
    public function compactFill(array $data): void
    {
        $this->fill($data);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttributeValue(self::ATTR_TITLE);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getAttributeValue(self::ATTR_CONTENT);
    }
}
