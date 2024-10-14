<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class ShowRoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function __invoke(int $id_role, Request $request)
    {
        try {
            $role = $this->roleService->find($id_role);
            $role->load('protocols');
            return response()->json(['success' => 'Role fetched successfully', 'data' => $role]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
