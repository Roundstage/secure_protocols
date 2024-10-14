<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Protocol;
use Illuminate\Database\Eloquent\Model;

class RoleService implements CrudService
{
    protected Model $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->all();
    }

    public function find(int $id)
    {
        return $this->role->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->role->create($data);
    }

    public function update(int $id, array $data)
    {
        $role = $this->find($id);
        $role->update($data);
        return $role;
    }

    public function delete(int $id)
    {
        $role = $this->find($id);
        $role->delete();
        return $role;
    }

    public function getModel(): Role
    {
        return $this->role;
    }

    public function assignProtocolsToRole(int $role_id, array $protocols)
    {
        $role = $this->find($role_id); // Use the find method in the RoleService class
        $role->protocols()->sync($protocols);
        $role->load('protocols'); // Ensure the role has the most recent protocols
        return $role;
    }
}
