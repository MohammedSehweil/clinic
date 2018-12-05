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


    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'clinic_user', 'clinic_id', 'user_id');
    }


}
