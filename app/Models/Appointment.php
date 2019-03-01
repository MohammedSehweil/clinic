<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = ['id'];

    const SERVICE_MAP = [
        1 => 'Home Service',
        2 => 'Clinic Serive'
    ];

    const STATUS_MAP = [
        0 => 'Pending',
        1 => 'Confirmed'
    ];

    public function scopeAvailable($query)
    {
        return $query->where('reserved', false);
    }

    /**
     * Get the user for the medicalRecord.
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\Auth\User', 'patient_id');
    }

    /**
     * Get the user for the medicalRecord.
     */
    public function doctor()
    {
        return $this->belongsTo('App\Models\Auth\User', 'doctor_id');
    }

    /**
     * Get the user for the medicalRecord.
     */
    public function clinic()
    {
        return $this->belongsTo('App\Models\Auth\Clinic', 'clinic_id');
    }
}
