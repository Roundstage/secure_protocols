<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssingProtocolRequest;
use App\Models\Protocol;
use App\Models\Role;

class AssingProtocolToRoleController extends Controller
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
                $role->protocols()->sync($validatedRequest['protocols']);
            }
            $role->save();

            return response()->json([
                'success' => 'Protocol added to role successfully.',
                'data' => $role->fresh(), // Using fresh() to get the latest state of the user
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage(), 'data'=>null]);
        }

    }
}
