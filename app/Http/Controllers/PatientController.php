<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Http\Requests\Backend\Auth\Role\PatientRequest;
use App\Models\Auth\Patient;
use App\Models\Auth\Role;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;

/**
 * Class PatientController.
 */
class PatientController extends Controller
{
    public function __construct()
    {
    }

    public function index(PatientRequest $request)
    {

        $patients = Patient::query()
            ->orderBy('id', 'asc')
            ->paginate(25);

        return view('patient.index', compact('patients'));

    }

    public function create(PatientRequest $request)
    {
        return view('patient.create');
    }


    public function show(PatientRequest $request, Patient $patient)
    {
        return view('patient.show', compact('patient'));
    }

    public function store(PatientRequest $request)
    {
        $patient = Patient::query()
            ->create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'password' => $request->get('password'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'type' => 'patient'
            ]);


        $clinics = array_values($request->get('clinics') ?? []);
        $patient->clinics()->sync($clinics);

        return redirect()->route('admin.patient.index')->withFlashSuccess('The patient was successfully saved.');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(PatientRequest $request, Patient $patient)
    {

        return view('patient.edit', compact('patient'));
    }


    public function update(PatientRequest $request, Patient $patient)
    {

        $patient
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
        $patient->clinics()->sync($clinics);

        return redirect()->route('admin.patient.index')->withFlashSuccess('The patient was successfully updated.');
    }


    public function destroy(PatientRequest $request, Patient $patient)
    {

        $patient->delete();

        return redirect()->route('admin.patient.index')->withFlashSuccess('The patient was successfully deleted.');
    }
}
