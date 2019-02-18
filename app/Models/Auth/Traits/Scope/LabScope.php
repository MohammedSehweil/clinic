<?php

namespace App\Models\Auth\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ClinicScope.
 */
trait LabScope
{
    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootLabScope()
    {
        static::addGlobalScope('lab', function (Builder $builder) {
            $builder->where('facility_id', 3);
        });
    }
}
