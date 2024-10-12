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
    public function __invoke($id_role, Request $request)
    {
        try {
            $role = Role::findOrFail($id_role);
            $role->load('protocols');
            return response()->json($role);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
