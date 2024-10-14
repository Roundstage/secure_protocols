<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface CrudService
{
    public function all();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function find(int $id);

    public function getModel(): Model;
}
