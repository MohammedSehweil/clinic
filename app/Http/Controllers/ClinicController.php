<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Http\Requests\Backend\Auth\Role\ClinicRequest;
use App\Models\Auth\Clinic;
use App\Models\Auth\Role;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
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
        Clinic::query()
            ->create([
                'name' => $request->get('name')
            ]);


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

        $clinic->update(['name' => $request->get('name')]);

        return redirect()->route('admin.clinic.index')->withFlashSuccess('The clinic was successfully updated.');
    }


    public function destroy(ClinicRequest $request, Clinic $clinic)
    {

        $clinic->delete();

        return redirect()->route('admin.clinic.index')->withFlashSuccess('The clinic was successfully deleted.');
    }
}
