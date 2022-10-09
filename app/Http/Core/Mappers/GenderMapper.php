<?php

declare(strict_types=1);

namespace App\Http\Core\Mappers;

final class GenderMapper
{
    public const GENDER_MALE = 1;

    public const GENDER_FEMALE = 2;

    public function getGender(int $gender): string
    {
        return match ($gender) {
            self::GENDER_FEMALE => 'Female',
            default => 'Male',
        };
    }
}
