<?php

namespace App\Methods;


use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\Doctor;
use App\Models\Auth\UserClinicSpecialties;
use Illuminate\Database\Eloquent\Model;

class PrivateDoctorMethods
{

    public function getPrivateDoctorSpecialties($user)
    {
        return $user->specialties()->pluck('user_specialties.specialties_id')->toArray();
    }

}