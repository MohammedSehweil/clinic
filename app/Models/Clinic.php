<?php

namespace App\Models\Auth;

use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Traits\Scope\ClinicScope;
use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;

/**
 * Class Role.
 */
class Clinic extends Model
{
    use ClinicScope;
    use ClinicAttribute;

    protected $table = 'clinics';
    protected $guarded = ['id'];

    protected $attributes = [
        'facility_id' => 9
    ];

    public function specialties()
    {
        return $this->belongsToMany(Specialties::class, 'clinic_specialties', 'clinic_id');
    }

    public function scopeApproved($query)
    {
        return $query->wherer('approved', true);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the facility that has the clinic.
     */
    public function facility()
    {
        return $this->belongsTo('Clinic\Models\facility');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Auth\Appointment');
    }
}
