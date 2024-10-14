<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditRoleRequest;
use App\Models\Role;
use Illuminate\Http\Response;

class UpdateRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EditRoleRequest $request)
    {
        try {
            $role = Role::findOrFail($request->id);
            $role->update($request->validated());

            return response()->json([
                'message' => 'Role updated successfully',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating role',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
