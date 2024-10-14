<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;

class DeleteRoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $this->roleService->delete($id);
            return response()->json(['success' => 'Role deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting role: ' . $e->getMessage()], 500);
        }
    }
}
