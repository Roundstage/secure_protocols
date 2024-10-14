<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'level'
    ];
    public $timestamps = false;
    public function permissions(){

    }
    public function protocols(): BelongsToMany
    {
        return $this->belongsToMany(Protocol::class, 'roles_protocols', 'role_id', 'protocol_id');
    }

}
