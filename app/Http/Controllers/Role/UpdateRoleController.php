<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Services\RoleService;

class UpdateRoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $role_id, EditRoleRequest $request)
    {
        try {
            $updatedRole = $this->roleService->update($role_id, $request->validated());

            return response()->json([
                'message' => 'Role updated successfully',
                'data' => $updatedRole
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating role',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
