<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssingProtocolRequest;
use App\Http\Requests\AssingRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\Request;
use App\Services\UserService;

class AssignRoleToUserController extends Controller
{
    protected RoleService $roleService;
    protected UserService $userService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $user_id, int $role_id, AssingRoleRequest $request)
    {
        try {
            $user = $this->userService->assignRoleToUser($user_id, $this->roleService->find($role_id));
            return response()->json([
                'success' => 'Role added successfully.',
                'data' => $user, // Using fresh() to get the latest state of the user
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }
    }
}
