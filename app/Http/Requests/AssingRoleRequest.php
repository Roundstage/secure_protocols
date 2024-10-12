<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssingRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $role = auth()->user()->role()->get();
        return $role->contains('level', 'Manager');
    }
}
