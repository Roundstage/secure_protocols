<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Models\Role;

class CreateRoleController extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            // processo de criação do item com a model Role
            $role = Role::create($request->validated());
            return response()->json(['success' => 'Role created successfully', 'data' => $role], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar o item: ' . $e->getMessage()], 500);
        }
    }
}
