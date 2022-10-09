<?php

declare(strict_types=1);

namespace App\Http\Core\Helpers;

use Illuminate\Database\Query\Expression;

final class QueryUtils
{
    /**
     * Get column name from select expression.
     *
     * @param string|\Illuminate\Database\Query\Expression $select
     *
     * @return string
     */
    public static function getColumnFromSelect(string | Expression $select): string
    {
        if ($select instanceof Expression) {
            $select = $select->getValue();
        }

        if (! \is_string($select)) {
            $select = (string) $select;
        }

        $asIndex = \strripos($select, ' as ');

        if ($asIndex) {
            return \substr($select, $asIndex + 4);
        }

        $prefixEndsOnIndex = \strrpos($select, '.');
        return \substr($select, $prefixEndsOnIndex ? $prefixEndsOnIndex + 1 : 0);
    }

    /**
     * Prefix column if is not already prefixed.
     *
     * @param string $column
     * @param string $table
     *
     * @return string
     */
    public static function prefixNotPrefixedColumn(string $column, string $table): string
    {
        if (\str_contains($column, '.')) {
            return $column;
        }

        return self::prefixColumn($column, $table);
    }

    /**
     * Prefix column.
     *
     * @param string $column
     * @param string $table
     *
     * @return string
     */
    public static function prefixColumn(string $column, string $table): string
    {
        return "$table.$column";
    }
}