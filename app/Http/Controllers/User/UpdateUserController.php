<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;

class UpdateUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id_user, EditUserRequest $request)
    {
        try {
            $user = User::findOrFail($id_user);
            $user->update($request->validated());

            return response()->json([
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
