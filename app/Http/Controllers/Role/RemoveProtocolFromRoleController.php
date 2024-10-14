<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssingProtocolRequest;
use App\Models\Protocol;
use App\Models\Role;
use Illuminate\Http\Request;

class RemoveProtocolFromRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $role_id, AssingProtocolRequest $request)
    {
        try {
            $validatedRequest = $request->validated();
            $role = Role::findOrFail($role_id);
            foreach ($validatedRequest['protocols'] as $protocol){
                $protocol = Protocol::findOrFail($protocol);
                $role->protocols()->detach($protocol);
            }
            $role->save();
            return response()->json(['success' => 'Protocols removed successfully'], 204);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
