<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'firstName'  => ['required', 'string', 'max:255'],
            'lastName'   => ['required', 'string', 'max:255'],
            'userName'   => ['required', 'string', 'max:50',Rule::unique('users', 'userName')->ignore($userId),],
            'companyId'  => [$this->routeIs('employees.*') ? 'required' : 'nullable','exists:companies,id',],
            'email' => ['required', 'email', 'max:255',Rule::unique('users', 'email')->ignore($userId),],
            'phone' => ['nullable', 'string', 'max:20'],
            'empPhoto' => [$this->routeIs('employees.*') ? 'required' : 'sometimes','image','max:2048'],
        ];
    }
}
