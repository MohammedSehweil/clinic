<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Models\Auth\Lab;
use App\Models\Auth\Role;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Http\Requests\Backend\Auth\Role\ClinicRequest;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;

/**
 * Class LabController.
 */
class LabController extends Controller
{
    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ClinicRequest $request)
    {
        $doctorsFilter = $request->get('doctors', []);
        $labsFilter = $request->get('labs', []);
        $specialtiesFilter = $request->get('specialties', []);
        $countriesFilter = $request->get('countries', []);
        $cityFilter = $request->get('city', []);


        $user = \Auth::user();
        $labs = Lab::query()
            ->when($labsFilter, function ($q) use ($labsFilter) {
                return $q->whereIn('clinics.id', $labsFilter);
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
            return view('lab.partial.table', compact('labs'));
        }

        return view('lab.index', compact('labs'));
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function create(ClinicRequest $request)
    {
        return view('lab.create');
    }


    public function show(ClinicRequest $request, Lab $lab)
    {
        return view('lab.show', compact('lab'));
    }


    public function store(ClinicRequest $request)
    {
        $lab = Lab::query()
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

        $lab->specialties()->sync($specialtiesIds);

        $ids = [];
        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $ids[] = $object->id;
        }


        $lab->specialties()->syncWithoutDetaching($ids);


        return redirect()->route('admin.lab.index')
            ->withFlashSuccess('The lab was successfully saved.');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(ClinicRequest $request, Lab $lab)
    {
        return view('lab.edit', compact('lab'));
    }

    public function update(ClinicRequest $request, Lab $lab)
    {
        $lab->update([
            'name' => $request->get('name'),
            'country_id' => $request->get('country_id'),
            'city' => $request->get('city', null),
            'description' => $request->get('description', null),
        ]);


        $specialties = $request->get('specialties', []);
        $specialtiesIds = array_filter($specialties, 'is_numeric');
        $specialtiesNames = [];


        foreach ($specialties as $specialty) {
            if (!is_numeric($specialty)) {
                $specialtiesNames[] = $specialty;
            }
        }

        $lab->specialties()->sync($specialtiesIds);

        $ids = [];
        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $ids[] = $object->id;
        }


        $lab->specialties()
            ->syncWithoutDetaching($ids);


        return redirect()->route('admin.lab.index')
            ->withFlashSuccess('The lab was successfully updated.');
    }


    public function destroy(ClinicRequest $request, Lab $lab)
    {
        $lab->delete();

        return redirect()->route('admin.lab.index')
            ->withFlashSuccess('The lab was successfully deleted.');
    }


    public function approve(Lab $lab)
    {
        if (!$lab->approved) {
            $lab->approved = true;
            $lab->save();
        }

        return response()
            ->json(['message' => 'The lab was successfully approved.'], 200);
    }


    public function reject(Lab $lab)
    {
        if ($lab->approved) {
            $lab->approved = false;
            $lab->save();
        }

        return response()
            ->json(['message' => 'The lab was successfully rejected.'], 200);
    }
}
