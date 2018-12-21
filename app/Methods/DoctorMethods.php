<?php

namespace App\Methods;


use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\Doctor;
use App\Models\Auth\UserClinicSpecialties;
use Illuminate\Database\Eloquent\Model;

class DoctorMethods
{

    public function getDoctorClinics($doctor)
    {
        $doctor = $this->getObject($doctor);
        $clinic_specialties_ids = $doctor->clinic_specialties()->pluck('clinic_specialties_id')->toArray();
        $clinics = ClinicSpecialties::query()
            ->whereIn('clinic_specialties.id', $clinic_specialties_ids)
            ->join('clinics', 'clinics.id', '=', 'clinic_specialties.clinic_id')
            ->pluck('clinics.name', 'clinics.id')
            ->toArray();

        return array_unique($clinics);
    }


    public function getDoctorSpecialties($doctor)
    {
        $doctor = $this->getObject($doctor);
        $clinic_specialties_ids = $doctor->clinic_specialties()->pluck('clinic_specialties_id')->toArray();
        $specialties = ClinicSpecialties::query()
            ->whereIn('clinic_specialties.id', $clinic_specialties_ids)
            ->join('specialties', 'specialties.id', '=', 'clinic_specialties.specialties_id')
            ->pluck('specialties.name', 'specialties.id')
            ->toArray();

        return array_unique($specialties);
    }


    public function getSpecialtiesDoctors($specialties)
    {
        $clinicSpecialtiesIds = ClinicSpecialties::query()
            ->where('specialties_id', $specialties->id)
            ->pluck('id')
            ->toArray();

        $users = UserClinicSpecialties::query()
            ->whereIn('user_clinic_specialties.clinic_specialties_id', $clinicSpecialtiesIds)
            ->join('users', 'users.id', 'user_clinic_specialties.user_id')
            ->get();

        $mappedUsers = [];
        foreach ($users as $user) {
            $mappedUsers[$user->id] = $user->first_name . ' ' . $user->last_name;
        }
        return $mappedUsers;
    }


    private function getObject($doctor)
    {
        if (is_null($doctor)) {
            return null;
        }

        if ($doctor instanceof Model) {
            return $doctor;
        }
        return Doctor::find($doctor);
    }

}