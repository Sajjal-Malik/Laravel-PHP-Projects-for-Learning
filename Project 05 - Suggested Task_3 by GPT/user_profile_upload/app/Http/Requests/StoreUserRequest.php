<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreUserRequest extends FormRequest
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

        return [
            'firstName'     => 'required|string|max:255',
            'lastName'      => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'age'           => 'required|integer|min:1',
            'phoneNumber'   => 'required|string|max:20',
            'bio'           => 'required|string',
            'DOB'           => 'required|date',
            'profileImage'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
