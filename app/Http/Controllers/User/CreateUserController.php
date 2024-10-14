<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

use App\Models\User;
class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return response()->json(['success' => 'User created successfully', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar o item: ' . $e->getMessage()], 500);
        }
    }
}
