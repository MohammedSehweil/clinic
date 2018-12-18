<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClinicSpecialties.
 */
class ClinicSpecialties extends Model
{

    protected $table = 'clinic_specialties';
    protected $guarded = ['id'];




}
