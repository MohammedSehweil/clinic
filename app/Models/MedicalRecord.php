<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the user for the medicalRecord.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Auth\Appointment');
    }
}
