<?php

namespace App\Services;

use App\Models\Protocol;
use Illuminate\Database\Eloquent\Model;

class ProtocolService implements CrudService
{
    protected Model $protocol;

    public function __construct(Protocol $protocol)
    {
        $this->protocol = $protocol;
    }

    public function all()
    {
        return $this->protocol->all();
    }

    public function create(array $data)
    {
        return $this->protocol->create($data);
    }

    public function update(int $id, array $data)
    {
        $protocol = $this->protocol->findOrFail($id);
        $protocol->update($data);
        return $protocol;
    }

    public function delete(int $id)
    {
        $protocol = $this->protocol->findOrFail($id);
        return $protocol->delete();
    }

    public function find(int $id)
    {
        return $this->protocol->findOrFail($id);
    }

    public function getModel(): Protocol
    {
        return $this->protocol;
    }
}
