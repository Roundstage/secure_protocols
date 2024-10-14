<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ShowRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id_role, Request $request)
    {
        try {
            $role = Role::findOrFail($id_role);
            $role->load('protocols');
            return response()->json(['success' => 'Role fetched successfully', 'data' => $role]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
