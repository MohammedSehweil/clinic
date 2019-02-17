<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Traits\ClinicAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role.
 */
class Clinic extends Model
{
    use ClinicAttribute;
    protected $table = 'clinics';
    protected $guarded = ['id'];


    const CLINIC_TYPE = 9;
    const LAB_TYPE = 3;

    public function specialties()
    {
        return $this->belongsToMany(Specialties::class, 'clinic_specialties', 'clinic_id');
    }

    public function scopeApproved($query)
    {
        return $query->wherer('approved', true);
    }

    public function scopeIsClinic($query)
    {
        return $query->wherer('facility_id', self::CLINIC_TYPE);
    }

    public function scopeIsLab($query)
    {
        return $query->wherer('facility_id', self::LAB_TYPE);
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
}
