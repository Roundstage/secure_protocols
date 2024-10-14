<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;

class ListRoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $roles = $this->roleService->all();
            $roles->load('protocols');
            return response()->json(['message' => 'Roles fetched successfully.', 'data' => $roles]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'roles' => null], 500);
        }
    }
}
