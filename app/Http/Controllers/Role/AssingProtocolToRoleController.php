<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssingProtocolRequest;
use App\Models\Protocol;
use App\Models\Role;
use App\Services\RoleService;

class AssingProtocolToRoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $role_id, AssingProtocolRequest $request)
    {
        try {
            $validatedRequest = $request->validated();
            $role = $this->roleService->assignProtocolsToRole($role_id, $validatedRequest['protocols']);
            return response()->json([
                'success' => 'Protocol added to role successfully.',
                'data' => $role, // Using fresh() to get the latest state of the user
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage(), 'data' => null]);
        }
    }
}
