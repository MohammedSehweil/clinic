<?php

namespace App\Methods;


use App\Models\Auth\Clinic;
use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\Doctor;
use App\Models\Auth\Specialties;
use Illuminate\Database\Eloquent\Model;

class GeneralMethods
{

    public function getAllDoctors()
    {
        $doctors = Doctor::all();

        $map = [];
        foreach ($doctors as $doctor){
            $map[$doctor->id] = $doctor->full_name;
        }
       return $map;
    }



    public function getAllClinics()
    {
        return Clinic::query()->pluck('name', 'id')->toArray();
    }


    public function getAllSpecialties()
    {
        return Specialties::query()->pluck('name', 'id')->toArray();
    }


}