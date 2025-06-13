<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        
        return [
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $userId,
            'password'  => 'nullable|string|min:6',
            'age'       => 'nullable|integer|min:1',
            'phoneNumber' => 'nullable|string|max:20',
            'bio'       => 'nullable|string',
            'dob'       => 'nullable|date',
        ];
    }
}
