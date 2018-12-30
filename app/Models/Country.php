<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country.
 */
class Country extends Model
{

    protected $table = 'countries';
    protected $guarded = ['id'];


    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }
}
