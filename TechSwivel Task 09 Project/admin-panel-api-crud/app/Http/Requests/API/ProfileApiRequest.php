<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ProfileApiRequest extends FormRequest
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
         $id = $this->route('profile');
         
        return [
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|unique:profiles,email,' . $id,
            'phoneNumber' => 'required|string|max:15',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
