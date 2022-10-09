<?php

declare(strict_types=1);

namespace App\Http\Containers\UsersContainer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Core\Models\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Public attributes const.
     */
    public const ATTR_ID = 'id';

    public const ATTR_NAME = 'name';

    public const ATTR_EMAIL = 'email';

    public const ATTR_PASSWORD = 'password';

    /**
     * Public limits
     */
    public const LIMIT_NAME = 256;

    /**
     * Relations
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_EMAIL,
        self::ATTR_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::ATTR_PASSWORD,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function getName(): string
    {
        return $this->getAttributeValue(self::ATTR_NAME);
    }

    public function getEmail(): string
    {
        return $this->getAttributeValue(self::ATTR_EMAIL);
    }

    public function getPassword(): string
    {
        return $this->getAttributeValue(self::ATTR_PASSWORD);
    }

    /**
     * Fill model with compact data.
     *
     * @param array<mixed> $data
     */
    public function compactFill(array $data): void
    {
        $this->fill($data);
    }
}
