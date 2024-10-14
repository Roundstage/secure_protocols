<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\AuthService;


class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(AuthRequest $request)
    {
        try {
            $validated = $request->validated();
            $email = $validated['email'];
            $password = $validated['password'];

            return response()->json($this->authService->authenticate($email, $password));

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }
}
