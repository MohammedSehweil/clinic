<?php

namespace App\Models\Auth\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ClinicScope.
 */
trait ClinicScope
{
    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootClinicScope()
    {
        static::addGlobalScope('clinic', function (Builder $builder) {
            $builder->where('facility_id', 9);
        });
    }
}
