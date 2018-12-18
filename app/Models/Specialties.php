<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Specialties.
 */
class Specialties extends Model
{

    use ClinicAttribute;
    protected $table = 'specialties';
    protected $guarded = ['id'];


    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_specialties', 'specialties_id');
    }



}
