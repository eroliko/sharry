<?php

declare(strict_types=1);

namespace App\Http\Containers\EventsContainer\Models;

use App\Http\Containers\UsersContainer\Models\User;
use App\Http\Core\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

final class Events extends Model
{
    /**
     * Public attributes
     */
    public const ATTR_ID = 'id';

    public const ATTR_VALID_FROM = 'valid_from';

    public const ATTR_VALID_TO = 'valid_to';

    public const ATTR_TITLE = 'title';

    public const ATTR_CONTENT = 'content';

    public const ATTR_GPS_LAT = 'gps_lat';

    public const ATTR_GPS_LNG = 'gps_lng';

    public const ATTR_CREATED_AT = parent::CREATED_AT;

    public const ATTR_UPDATED = parent::UPDATED_AT;

    /**
     * Public limits
     */
    public const LIMIT_TITLE = 128;

    public const LIMIT_CONTENT = 2048;

    public const LIMIT_GPS = 64;

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
        self::ATTR_VALID_FROM,
        self::ATTR_VALID_TO,
        self::ATTR_GPS_LNG,
        self::ATTR_GPS_LAT,
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
            'users_events',
            'event_id',
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

    public function getTitle(): string
    {
        return $this->getAttributeValue(self::ATTR_TITLE);
    }

    public function getContent(): string
    {
        return $this->getAttributeValue(self::ATTR_CONTENT);
    }

    public function getValidFrom(): string
    {
        return $this->getAttributeValue(self::ATTR_VALID_FROM);
    }

    public function getValidTo(): string
    {
        return $this->getAttributeValue(self::ATTR_VALID_TO);
    }

    public function getGpsLat(): string
    {
        return $this->getAttributeValue(self::ATTR_GPS_LAT);
    }

    public function getGpsLng(): string
    {
        return $this->getAttributeValue(self::ATTR_GPS_LNG);
    }
}
