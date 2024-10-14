<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssingProtocolRequest;
use App\Http\Requests\AssingRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AssignRoleToUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $user_id, int $role_id, AssingRoleRequest $request){
        try {
            $user = User::findOrFail($user_id);
            $role = Role::findOrFail($role_id);
            $user->role()->associate($role);
            $user->save();

            return response()->json([
                'success' => 'Role added successfully.',
                'data' => $user->fresh(), // Using fresh() to get the latest state of the user
            ]);
        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 403);
        }
    }
}
