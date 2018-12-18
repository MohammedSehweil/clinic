<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserClinicSpecialties.
 */
class UserClinicSpecialties extends Model
{

//    use ClinicAttribute;
    protected $table = 'user_clinic_specialties';
    protected $guarded = ['id'];




}
