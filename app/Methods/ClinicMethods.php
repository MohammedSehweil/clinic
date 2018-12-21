<?php

namespace App\Methods;


use App\Models\Auth\Clinic;
use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\Doctor;
use App\Models\Auth\UserClinicSpecialties;
use Illuminate\Database\Eloquent\Model;

class ClinicMethods
{

    public function getClinicDoctors($clinic)
    {
        $clinic = $this->getObject($clinic);

        $clinic_specialties_ids = $clinic->specialties()->pluck('clinic_specialties.id')->toArray();


        $doctors = UserClinicSpecialties::query()
            ->whereIn('user_clinic_specialties.clinic_specialties_id', $clinic_specialties_ids)
            ->join('users', 'users.id', '=', 'user_clinic_specialties.user_id')
            ->get();

        $mappedDoctors = [];
        foreach ($doctors as $doctor) {
            $mappedDoctors[] = $doctor->first_name . ' ' . $doctor->last_name;
        }

        return array_unique($mappedDoctors);
    }


    public function getDoctorSpecialties($doctor)
    {
        $doctor = $this->getObject($doctor);
        $clinic_specialties_ids = $doctor->clinic_specialties()->pluck('clinic_specialties_id')->toArray();
        $specialties = ClinicSpecialties::query()
            ->whereIn('clinic_specialties.id', $clinic_specialties_ids)
            ->join('specialties', 'specialties.id', '=', 'clinic_specialties.specialties_id')
            ->pluck('specialties.name')
            ->toArray();

        return array_unique($specialties);
    }

    public function getClinicSpecialties($clinic)
    {
        $clinic_specialties_ids = $clinic->specialties()->pluck('specialties_id')->toArray();
        return $clinic_specialties_ids;
    }

    private function getObject($clinic)
    {
        if (is_null($clinic)) {
            return null;
        }

        if ($clinic instanceof Model) {
            return $clinic;
        }
        return Clinic::find($clinic);
    }

}