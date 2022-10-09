<?php

declare(strict_types=1);

namespace App\Http\Containers\CommentsContainer\Models;

use App\Http\Core\Models\Model;

final class Comments extends Model
{
    /**
     * Public attributes
     */
    public const ATTR_ID = 'id';

    public const ATTR_NICKNAME = 'nick_name';

    public const ATTR_CONTENT= 'content';

    /**
     * Public limits
     */
    public const LIMIT_NICKNAME = 128;

    public const LIMIT_CONTENT = 2048;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        self::ATTR_NICKNAME,
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

    /**
     * Fill model with compact data.
     *
     * @param array $data
     */
    public function compactFill(array $data): void
    {
        $this->fill($data);
    }

    public function getNickName(): string
    {
        return $this->getAttributeValue(self::ATTR_NICKNAME);
    }
}
