<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create($request->validated());
            return response()->json(['success' => 'User created successfully', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar o item: ' . $e->getMessage()], 500);
        }
    }
}
