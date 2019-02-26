<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\Patient;
use Illuminate\Http\Request;
use App\Models\Auth\Appointment;
use App\Models\Auth\MedicalRecord;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentsResource;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Http\Requests\Backend\Auth\Role\PatientRequest;
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
        if (true) {
            $patients = Patient::query()
                ->orderBy('id', 'asc')
                ->paginate(25);
        } elseif (isPatient()) {
            $user = \Auth::user();

            $patients = Patient::query()
                ->where('id', '=', $user->id)
                ->orderBy('id', 'asc')
                ->paginate(25);
        }


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
                'password' => bcrypt($request->get('password')),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'type' => 'patient'
            ]);

        $user = User::find($patient->id);
        $user->assignRole('administrator');


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
        if (isCurrentUser($patient->id)) {
            $patient
                ->update([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'password' => $request->get('password'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'confirmation_code' => md5(uniqid(mt_rand(), true)),
                    'confirmed' => true,
                    'type' => 'patient'
                ]);
        } else {
            $patient
                ->update([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'confirmation_code' => md5(uniqid(mt_rand(), true)),
                    'confirmed' => true,
                    'type' => 'patient'
                ]);
        }

        $clinics = array_values($request->get('clinics') ?? []);
        $patient->clinics()->sync($clinics);

        return redirect()->route('admin.patient.index')->withFlashSuccess('The patient was successfully updated.');
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return mixed
     * @throws \Exception
     */
    public function destroy(PatientRequest $request, Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patient.index')->withFlashSuccess('The patient was successfully deleted.');
    }

    public function reserve(Request $request)
    {
        $appointment = Appointment::find($request->get('appointment_id'));

        if (! \Auth::user()->medicalRecord) {
            $medicalRecord = new MedicalRecord();
            $medicalRecord->user_id = \Auth::user()->id;

            \Auth::user()->medicalRecord()->save($medicalRecord);
        }

        if ($appointment && ! $appointment->reserved) {
            $appointment->update([
                'reserved' => true,
                'patient_id' => \Auth::user()->id
            ]);
        }
    }

    public function getAppointments()
    {
        return new AppointmentsResource(\Auth::user()->myAppointments);
    }
}
