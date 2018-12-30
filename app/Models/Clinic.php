<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role.
 */
class Clinic extends Model
{

    use ClinicAttribute;
    protected $table = 'clinics';
    protected $guarded = ['id'];


    public function specialties()
    {
        return $this->belongsToMany(Specialties::class, 'clinic_specialties', 'clinic_id');
    }

    public function scopeApproved($query)
    {
        return $query->wherer('approved', true);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
