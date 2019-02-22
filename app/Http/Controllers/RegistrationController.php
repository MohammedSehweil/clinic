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
 * Class RegistrationController.
 */
class RegistrationController extends Controller
{
    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ClinicRequest $request)
    {
        dd('SOON');
        return view('lab.index', compact('labs'));
    }

}
