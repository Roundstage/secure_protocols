<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService implements CrudService
{
    protected Model $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function find(int $id)
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->find($id);
        $user->delete();
        return $user;
    }

    public function getModel(): User
    {
        return $this->user;
    }

    public function assignRoleToUser(int $user_id, Role $role)
    {
        $user = $this->find($user_id);
        $this->associateRoleWithUser($user, $role);

        return $user;
    }

    protected function associateRoleWithUser(User $user, Role $role): void
    {
        $user->role()->associate($role);
        $user->save();
        $user->fresh();
        $user->load('role');
    }
}
