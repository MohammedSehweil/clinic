<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\Clinic;
use App\Models\Auth\Doctor;
use App\Models\Auth\Patient;
use App\Http\Controllers\Controller;
use App\Models\Auth\ClinicSpecialties;
use App\Models\Auth\UserClinicSpecialties;
use App\Http\Resources\AppointmentsResource;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;
use App\Http\Requests\Backend\Auth\Role\DoctorRequest;

/**
 * Class DoctorController.
 */
class DoctorController extends Controller
{
    public function __construct()
    {
    }

    public function index(DoctorRequest $request)
    {
        if (isOwner()) {
            $user = currentUser();
            $doctorsIds = Clinic::query()
                ->where('clinics.owner_id', $user->id)
                ->join('clinic_specialties', 'clinics.id', '=', 'clinic_specialties.clinic_id')
                ->join('user_clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
                ->pluck('user_clinic_specialties.user_id')
                ->toArray();


            $doctors = Doctor::query()
                ->whereIn('id', $doctorsIds)
                ->orderBy('id', 'asc')
                ->paginate(25);
        } elseif (isDoctor()) {
            $user = currentUser();
            $clinicsIds = UserClinicSpecialties::query()
                ->join('clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
                ->where('user_clinic_specialties.user_id', $user->id)
                ->pluck('clinic_specialties.clinic_id')
                ->toArray();

            $doctorsIds = UserClinicSpecialties::query()
                ->join('clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
                ->whereIn('clinic_specialties.clinic_id', $clinicsIds)
                ->pluck('user_id')
                ->toArray();

            $doctors = Doctor::query()
                ->whereIn('id', $doctorsIds)
                ->orderBy('id', 'asc')
                ->paginate(25);
        } else {
            $doctors = Doctor::query()
                ->orderBy('id', 'asc')
                ->paginate(25);
        }

        return view('doctor.index', compact('doctors'));
    }

    public function create(DoctorRequest $request)
    {
        return view('doctor.create');
    }


    public function show(DoctorRequest $request, Doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    public function store(DoctorRequest $request)
    {
        $doctor = Doctor::query()
            ->create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'password' => bcrypt($request->get('password')),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'type' => 'doctor'
            ]);


        $clinicId = $request->get('clinics', null);
        $specialtiesids = $request->get('specialties', []) ?? [];

        if ($clinicId) {
            $clinicSpecialtiesids = ClinicSpecialties::query()
                ->where('clinic_id', $clinicId)
                ->whereIn('specialties_id', $specialtiesids)
                ->pluck('clinic_specialties.id')
                ->toArray();

            foreach ($clinicSpecialtiesids as $val) {
                UserClinicSpecialties::query()
                    ->create([
                        'user_id' => $doctor->id,
                        'clinic_specialties_id' => $val
                    ]);
            }
        }

        $user = User::find($doctor->id);
        $user->assignRole('administrator');

        return redirect()->route('admin.doctor.index')->withFlashSuccess('The doctor was successfully saved.');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(DoctorRequest $request, Doctor $doctor)
    {
        return view('doctor.edit', compact('doctor'));
    }


    public function update(DoctorRequest $request, Doctor $doctor)
    {
        if (isCurrentUser($doctor->id)) {
            $doctor
                ->update([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'password' => $request->get('password'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'confirmation_code' => md5(uniqid(mt_rand(), true)),
                    'confirmed' => true,
                    'type' => 'doctor'
                ]);
        } else {
            $doctor
                ->update([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'confirmation_code' => md5(uniqid(mt_rand(), true)),
                    'confirmed' => true,
                    'type' => 'doctor'
                ]);
        }

        $clinicId = $request->get('clinics', null);
        $specialtiesids = $request->get('specialties', []) ?? [];

        if ($clinicId) {
            $clinicSpecialtiesids = ClinicSpecialties::query()
                ->where('clinic_id', $clinicId)
                ->whereIn('specialties_id', $specialtiesids)
                ->pluck('clinic_specialties.id')
                ->toArray();

            foreach ($clinicSpecialtiesids as $val) {
                UserClinicSpecialties::query()
                    ->updateOrCreate([
                        'user_id' => $doctor->id,
                        'clinic_specialties_id' => $val
                    ], []);
            }
        }


        return redirect()->route('admin.doctor.index')->withFlashSuccess('The doctor was successfully updated.');
    }


    public function destroy(DoctorRequest $request, Doctor $doctor)
    {
        try {
            $doctor->delete();
        } catch (\Exception $e) {
        }

        return redirect()->route('admin.doctor.index')->withFlashSuccess('The doctor was successfully deleted.');
    }

    public function getAppointments()
    {
        return new AppointmentsResource(\Auth::user()->appointments);
    }
}
