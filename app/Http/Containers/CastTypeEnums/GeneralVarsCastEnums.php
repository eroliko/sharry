<?php

declare(strict_types=1);

namespace App\Http\Containers\CastTypeEnums;

use App\Http\Core\Casts\CastTypeEnums;

/**
 * @brief General cast type enums for vars
 */
final class GeneralVarsCastEnums extends CastTypeEnums
{
    public const STRING = 'string';

    public const BOOL = 'bool';

    public const INT = 'int';

    public const DOUBLE = 'double';

    public const FLOAT = 'float';

    public const DATETIME = 'datetime';

    public const DATE = 'date';

    public const ARRAY = 'array';
}