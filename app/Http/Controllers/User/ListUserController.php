<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;

class ListUserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $users = $this->userService->all();
            return response()->json(['message' => 'Users retrieved successfully.', 'data' => $users]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'users' => null], 500);
        }
    }
}

