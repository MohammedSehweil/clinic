<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\Clinic;
use App\Models\Auth\Patient;
use Illuminate\Http\Request;
use App\Models\Auth\Appointment;
use App\Models\Auth\Specialties;
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
        $clinics = Clinic::whereIn('id', $request->get('clinic_ids'));

        foreach ($clinics as $clinic) {
            $appointment = Appointment::find($clinic->appointments[0]);


            if (! \Auth::user()->medicalRecord) {
                $medicalRecord = new MedicalRecord();
                $medicalRecord->user_id = \Auth::user()->id;

                \Auth::user()->medicalRecord()->save($medicalRecord);
            }

            if ($appointment && ! $appointment->reserved) {
                $appointment->update([
                    'reserved' => true,
                    'patient_id' => \Auth::user()->id,
                    'status' => 0,
                    'group_code' => \Auth::user()->id.'#'.$clinics->pluck('id')

                ]);
            }
        }
    }

    public function getAppointments(PatientRequest $request, $patientId)
    {
        return new AppointmentsResource(User::find($patientId)->myAppointments);
    }

    public function anyAppointment(PatientRequest $request)
    {
        $appointments = [];

        if ($request->get('start_at') && $request->get('specialty')) {
            $clinics = Specialties::find($request->get('specialty'))
                ->clinics
                ->map(function ($clinic) use ($request, &$appointments) {
                    array_push($appointments, $clinic->appointments()
                        ->available()
                        ->where('start_at', $request->get('start_at'))
                        ->get());
                });

            foreach (array_flatten($appointments, 1) as $appointment) {
                $appointment->update([
                    'status' => 0,
                    'reserved' => true,
                    'patient_id' => \Auth::user()->id,
                    'group_code' => \Auth::user()->id.'#'.$request->get('specialty')
                ]);
            }
        }
    }

    public function search(Request $request)
    {
        $appointments= $this->loadQuery($request)
            ->get();

        return $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->clinic->id,
                'name' =>$appointment->clinic->name
            ];
        });
    }

    public function loadQuery($request)
    {
        // Allow custom params from request
        $permittedParams = ['doctor_id', 'service_type', 'clinic_id', 'start_at'];

        $query = Appointment::query()->where('reserved', false);

        foreach ($permittedParams as $param) {
            if ($value = $request->get($param)) {
                $query->where($param, $value);
            }
        }

        if ($request->get('range')) {
            return $query->whereBetween('start_at', $request->get('range'));
        }

        return $query;
    }
}
