<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Models\Auth\Clinic;
use App\Models\Auth\Role;
use App\Models\Auth\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\AppointmentsResource;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Http\Requests\Backend\Auth\Role\ClinicRequest;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;

/**
 * Class ClinicController.
 */
class ClinicController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ClinicRequest $request)
    {
        $doctorsFilter = $request->get('doctors', []);
        $clinicsFilter = $request->get('clinics', []);
        $specialtiesFilter = $request->get('specialties', []);
        $countriesFilter = $request->get('countries', []);
        $cityFilter = $request->get('city', []);


        $user = \Auth::user();
        $clinics = Clinic::query()
            ->when($clinicsFilter, function ($q) use ($clinicsFilter) {
                return $q->whereIn('clinics.id', $clinicsFilter);
            })
            ->when($doctorsFilter, function ($q) use ($doctorsFilter) {
                return $q->whereHas('specialties', function ($query) use ($doctorsFilter) {
                    $query = $query->join('user_clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
                        ->whereIn('user_clinic_specialties.user_id', $doctorsFilter);
                    return $query;
                });
            })
            ->when($specialtiesFilter, function ($q) use ($specialtiesFilter) {
                return $q->whereHas('specialties', function ($query) use ($specialtiesFilter) {
                    return $query->whereIn('specialties.id', $specialtiesFilter);
                });
            })
            ->when($countriesFilter, function ($q) use ($countriesFilter) {
                return $q->whereIn('clinics.country_id', $countriesFilter);
            })
            ->when($cityFilter, function ($q) use ($cityFilter) {
                return $q->where('clinics.city', 'LIKE', "%$cityFilter%");
            })
            ->when($user->type == 'owner', function ($q) use ($user) {
                return $q->where('owner_id', $user->id);
            })
            ->when($user->type == 'patient', function ($q) use ($user) {
                return $q->where('approved', 1);
            })
            ->when($user->type == 'doctor', function ($q) use ($user) {
                return $q->whereHas('specialties', function ($query) {
                    $query = $query->join('user_clinic_specialties', 'clinic_specialties.id', '=', 'user_clinic_specialties.clinic_specialties_id')
                        ->whereIn('user_clinic_specialties.user_id', [currentUser()->id]);
                    return $query;
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(25);

        if ($request->get('view', false)) {
            return view('clinic.partial.table', compact('clinics'));
        }
        return view('clinic.index', compact('clinics'));
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function create(ClinicRequest $request)
    {
        return view('clinic.create');
    }


    public function show(ClinicRequest $request, Clinic $clinic)
    {
        return view('clinic.show', compact('clinic'));
    }

    public function store(ClinicRequest $request)
    {
        $clinic = Clinic::query()
            ->create([
                'name' => $request->get('name'),
                'owner_id' => currentUser()->id,
                'country_id' => $request->get('country_id'),
                'city' => $request->get('city', null),
                'description' => $request->get('description', null)
            ]);

        $specialties = $request->get('specialties', []);
        $specialtiesIds = array_filter($specialties, 'is_numeric');
        $specialtiesNames = [];


        foreach ($specialties as $specialty) {
            if (!is_numeric($specialty)) {
                $specialtiesNames[] = $specialty;
            }
        }

        $clinic->specialties()->sync($specialtiesIds);

        $ids = [];
        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $ids[] = $object->id;
        }


        $clinic->specialties()->syncWithoutDetaching($ids);


        return redirect()->route('admin.clinic.index')->withFlashSuccess('The clinic was successfully saved.');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(ClinicRequest $request, Clinic $clinic)
    {
        return view('clinic.edit', compact('clinic'));
    }


    public function update(ClinicRequest $request, Clinic $clinic)
    {
        $clinic
            ->update(
                [
                    'name' => $request->get('name'),
                    'country_id' => $request->get('country_id'),
                    'city' => $request->get('city', null),
                    'description' => $request->get('description', null),
                ]
            );


        $specialties = $request->get('specialties', []);
        $specialtiesIds = array_filter($specialties, 'is_numeric');
        $specialtiesNames = [];


        foreach ($specialties as $specialty) {
            if (!is_numeric($specialty)) {
                $specialtiesNames[] = $specialty;
            }
        }

        $clinic->specialties()->sync($specialtiesIds);

        $ids = [];
        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $ids[] = $object->id;
        }


        $clinic->specialties()->syncWithoutDetaching($ids);


        return redirect()->route('admin.clinic.index')->withFlashSuccess('The clinic was successfully updated.');
    }


    public function destroy(ClinicRequest $request, Clinic $clinic)
    {
        $clinic->delete();

        return redirect()->route('admin.clinic.index')->withFlashSuccess('The clinic was successfully deleted.');
    }


    public function approve(Clinic $clinic)
    {
        if (!$clinic->approved) {
            $clinic->approved = true;
            $clinic->save();
        }

        return response()->json(['message' => 'The clinic was successfully approved.'], 200);
    }


    public function reject(Clinic $clinic)
    {
        if ($clinic->approved) {
            $clinic->approved = false;
            $clinic->save();
        }

        return response()->json(['message' => 'The clinic was successfully rejected.'], 200);
    }


    public function getAppointments(ClinicRequest $request, $clinicId)
    {
        $appointments = Clinic::find($clinicId)->appointments;

        return new AppointmentsResource($appointments);
    }

    public function confirmAppointment(ClinicRequest $request, $clinicId, $appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        $appointments = Appointment::where('group_code', $appointment->group_code)
            ->where('id', '!=', $appointment->id)
            ->get()
            ->map(function ($appointment) {
                return $appointment->update([
                    'reserved' => false,
                    'patient_id' => null,
                    'group_code' => ''
                ]);
            });

        $appointment->update(['status' => true, 'group_code' => '']);

        return new AppointmentResource($appointment);
    }

    public function rejectAppointment(ClinicRequest $request, $clinicId, $appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        $appointment->update([
            'patient_id' => null,
            'reserved' => false,
            'group_code' => ''
        ]);

        return new AppointmentsResource(Clinic::find($clinicId)->appointments);
    }
}
