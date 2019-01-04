<?php

namespace App\Http\Controllers\Backend\Auth\Role;

use App\Http\Requests\Backend\Auth\Role\ClinicRequest;
use App\Http\Requests\Backend\Auth\Role\PrivateDoctorRequest;
use App\Models\Auth\Clinic;
use App\Models\Auth\PrivateDoctor;
use App\Models\Auth\Role;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;
use Illuminate\Http\Request;

/**
 * Class PrivateDoctorController.
 */
class PrivateDoctorController extends Controller
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
        $specialtiesFilter = $request->get('specialties', []);
        $countriesFilter = $request->get('countries', []);
        $cityFilter = $request->get('city', []);


        $user = \Auth::user();
        $privateDoctors = PrivateDoctor::query()
            ->when($doctorsFilter, function ($q) use ($doctorsFilter) {
                return $q->whereHas('specialties', function ($query) use ($doctorsFilter) {
                    $query = $query
                        ->whereIn('user_specialties.user_id', $doctorsFilter);
                    return $query;
                });
            })
            ->when($specialtiesFilter, function ($q) use ($specialtiesFilter) {
                return $q->whereHas('specialties', function ($query) use ($specialtiesFilter) {
                    return $query->whereIn('specialties.id', $specialtiesFilter);
                });
            })
            ->when($countriesFilter, function ($q) use ($countriesFilter) {
                return $q->whereIn('users.country_id', $countriesFilter);
            })
            ->when($cityFilter, function ($q) use ($cityFilter) {
                return $q->where('users.city', 'LIKE', "%$cityFilter%");
            })
            ->when($user->type == 'patient', function ($q) use ($user) {
                return $q->where('users.approved', 1);
            })
            ->when($user->type == 'private-doctor', function ($q) use ($user) {
                return $q->where('users.id', $user->id);
            })
            ->orderBy('id', 'asc')
            ->paginate(25);


        if ($request->get('view', false)) {
            return view('private-doctor.partial.table', compact('privateDoctors'));
        }
        return view('private-doctor.index', compact('privateDoctors'));

    }

    public function create(Request $request)
    {
        return view('private-doctor.create');
    }


    public function show(ClinicRequest $request, Clinic $privateDoctor)
    {
        return view('private-doctor.show', compact('private-doctor'));
    }

    public function store(PrivateDoctorRequest $request)
    {


        $specialties = $request->get('specialties', []);
        $specialtiesIds = array_filter($specialties, 'is_numeric');
        $specialtiesNames = [];


        foreach ($specialties as $specialty) {
            if (!is_numeric($specialty)) {
                $specialtiesNames[] = $specialty;
            }
        }


        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $specialtiesIds[] = $object->id;
        }

        $user = currentUser();
        $user
            ->update([
                'country_id' => $request->get('country_id'),
                'city' => $request->get('city', null),
                'description' => $request->get('description', null),
                'info_filled' => true,
                'approved' => false
            ]);


        $user->specialties()->sync($specialtiesIds);


        return redirect()->route('admin.private-doctor.index')->withFlashSuccess('The private-doctor was successfully saved.');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role $role
     *
     * @return mixed
     */
    public function edit(ClinicRequest $request, Clinic $privateDoctor)
    {

        return view('private-doctor.edit', compact('private-doctor'));
    }


    public function update(ClinicRequest $request, PrivateDoctor $privateDoctor)
    {

        $privateDoctor
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

        $privateDoctor->specialties()->sync($specialtiesIds);

        $ids = [];
        foreach ($specialtiesNames as $name) {
            $object = \App\Models\Auth\Specialties::query()->create([
                'name' => $name,
            ]);

            $ids[] = $object->id;
        }


        $privateDoctor->specialties()->syncWithoutDetaching($ids);


        return redirect()->route('admin.private-doctor.index')->withFlashSuccess('The private-doctor was successfully updated.');
    }


    public function destroy(ClinicRequest $request, Clinic $privateDoctor)
    {

        $privateDoctor->delete();

        return redirect()->route('admin.private-doctor.index')->withFlashSuccess('The private-doctor was successfully deleted.');
    }


    public function approve($privateDoctor)
    {
        $privateDoctor = PrivateDoctor::find($privateDoctor);
        if (!$privateDoctor->approved) {
            $privateDoctor->update(['approved' => true]);
        }

        return response()->json(['message' => 'The private-doctor was successfully approved.'], 200);
    }


    public function reject($privateDoctor)
    {
        $privateDoctor = PrivateDoctor::find($privateDoctor);

        if ($privateDoctor->approved) {
            $privateDoctor->update(['approved' => false]);
        }

        return response()->json(['message' => 'The private-doctor was successfully rejected.'], 200);
    }


}
