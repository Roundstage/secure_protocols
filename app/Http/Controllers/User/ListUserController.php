<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ListUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $users = User::all();
            $users->load('role');
            return response()->json(['message' => 'Protocol added to user successfully.', 'data' => $users]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'users' => null], 500);
        }
    }
}

