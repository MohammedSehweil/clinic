<?php

namespace App\Methods;

use App\Models\Auth\Lab;
use App\Models\Auth\Clinic;
use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\Country;
use App\Models\Auth\Doctor;
use App\Models\Auth\Nurse;
use App\Models\Auth\PrivateDoctor;
use App\Models\Auth\Specialties;
use Illuminate\Database\Eloquent\Model;

class GeneralMethods
{
    public function getAllDoctors()
    {
        $doctors = Doctor::all();

        $map = [];
        foreach ($doctors as $doctor) {
            $map[$doctor->id] = $doctor->full_name;
        }
        return $map;
    }


    public function getAllClinics()
    {
        return Clinic::query()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getAllLabs()
    {
        return Lab::query()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getAllSpecialties()
    {
        return Specialties::query()->pluck('name', 'id')->toArray();
    }


    public function getCurrentUserClinics()
    {
        $user = currentUser();
        return Clinic::query()
            ->when($user->type == 'owner', function ($query) use ($user) {
                $query
                    ->where('owner_id', $user->id);
            })
            ->pluck('name', 'id')
            ->toArray();
    }


    public function getClinicOwnerDoctorsIds()
    {
        // return doctor ids.

        $user = currentUser();
        if ($user->type != 'owner') {
            return [];
        }
        return Clinic::query()
            ->where('clinics.owner_id', $user->id)
            ->join('clinic_specialties', 'clinics.id', '=', 'clinic_specialties.clinic_id')
            ->join('user_clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
            ->pluck('user_clinic_specialties.user_id')
            ->toArray();
    }


    public function getAllCountries()
    {
        return Country::query()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getAllPrivateDoctors()
    {
        $doctors = PrivateDoctor::all();

        $map = [];
        foreach ($doctors as $doctor) {
            $map[$doctor->id] = $doctor->full_name;
        }
        return $map;
    }


    public function getAllNurses()
    {
        $nurses = Nurse::all();

        $map = [];
        foreach ($nurses as $nurse) {
            $map[$nurse->id] = $nurse->full_name;
        }
        return $map;
    }

}
