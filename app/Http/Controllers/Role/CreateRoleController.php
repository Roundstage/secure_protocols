<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Services\RoleService;

class CreateRoleController extends Controller
{
    protected RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            $role = $this->roleService->create($request->validated());
            return response()->json(['success' => 'Role created successfully', 'data' => $role], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar o item: ' . $e->getMessage()], 500);
        }
    }
}
