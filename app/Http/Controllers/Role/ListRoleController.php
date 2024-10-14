<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ListRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $roles = Role::all();
            $roles->load('protocols');
            return response()->json(['message' => 'Roles fetched successfully.', 'data'=>$roles]);
        } catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'roles'=>null], 500);
        }
    }
}
