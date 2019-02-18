<?php

namespace App\Models\Auth;

use App\Models\Traits\LabAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Traits\Scope\LabScope;
use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Auth\Traits\Attribute\RoleAttribute;

class Lab extends Model
{
    use LabScope;
    use LabAttribute;

    protected $table = 'clinics';
    protected $guarded = ['id'];

    protected $attributes = [
        'facility_id' => 3
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
}
