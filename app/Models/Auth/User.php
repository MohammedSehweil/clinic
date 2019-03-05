<?php

namespace App\Models\Auth;

use App\Models\Traits\Uuid;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'type',
        'phone',
        'country_id',
        'city',
        'description',
        'info_filled',
        'approved',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['last_login_at', 'deleted_at'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
    ];

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_user', 'user_id');
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialties::class, 'user_specialties', 'user_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne('App\Models\Auth\MedicalRecord');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Auth\Appointment', 'doctor_id');
    }

    public function myAppointments()
    {
        return $this->hasMany('App\Models\Auth\Appointment', 'patient_id');
    }

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('type', function (Builder $builder) {
//            $builder->where('type', '=', 'admin');
//        });
//    }
}
