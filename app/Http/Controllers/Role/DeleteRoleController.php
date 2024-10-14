<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class DeleteRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['success' => 'Role deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting role: ' . $e->getMessage()], 500);
        }
    }
}
