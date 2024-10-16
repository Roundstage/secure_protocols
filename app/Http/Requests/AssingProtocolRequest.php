<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssingProtocolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $role = auth()->user()->role()->get();
        return $role->contains('level', 'Manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'protocols' => ['required', 'array'],
            'protocols.*' => ['integer', 'exists:protocols,id'],
        ];
    }
}
