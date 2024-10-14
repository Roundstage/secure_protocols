<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DeleteUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $user_id)
    {
        try {
            User::destroy($user_id);
            return response()->json(['success' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
