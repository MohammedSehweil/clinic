<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type'
    ];

    public function scopeOfType($query, $type)
    {
        return $query->where('type', 'like', $type);
    }

    /**
     * Get the clinics for the facility.
     */
    public function clinics()
    {
        return $this->hasMany('App\Models\Auth\Clinic', 'facility_id');
    }
}
