<?php

declare(strict_types=1);

namespace App\Http\Containers\CastTypeEnumsContainer;

use App\Http\Core\Casts\CastTypeEnums;

class HttpCodesEnums extends CastTypeEnums
{
    public const HTTP_CREATED = 201;

    public const HTTP_OK = 200;

    public const HTTP_UPDATED = 204;

    public const HTTP_DELETED = 204;
}
