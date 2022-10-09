<?php

declare(strict_types=1);

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Relations\Relation;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @param string $relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getRelationInstance(string $relation): Relation
    {
        return $this->{$relation}();
    }
}