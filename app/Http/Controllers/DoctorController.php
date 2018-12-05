<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Http\Requests\Backend\Auth\Role\DoctorRequest;
use App\Models\Auth\Doctor;
use App\Models\Auth\Role;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;

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

        $doctors = Doctor::query()
            ->orderBy('id', 'asc')
            ->paginate(25);

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
                'password' => $request->get('password'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'type' => 'doctor'
            ]);


        $clinics = array_values($request->get('clinics') ?? []);
        $doctor->clinics()->sync($clinics);

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

        $clinics = array_values($request->get('clinics') ?? []);
        $doctor->clinics()->sync($clinics);

        return redirect()->route('admin.doctor.index')->withFlashSuccess('The doctor was successfully updated.');
    }


    public function destroy(DoctorRequest $request, Doctor $doctor)
    {

        $doctor->delete();

        return redirect()->route('admin.doctor.index')->withFlashSuccess('The doctor was successfully deleted.');
    }
}
