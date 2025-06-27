<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'userName'  => ['required', 'string', 'max:50',Rule::unique(User::class, 'userName'),],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique(User::class, 'email'),],
            'companyId' => ['nullable', 'exists:companies,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'firstName' => $input['firstName'],
            'lastName'  => $input['lastName'],
            'userName'  => $input['userName'],
            'email'     => $input['email'],
            'role'      => 2,
            'companyId' => $input['companyId'] ?? null,
            'phone'     => $input['phone']     ?? null,
            'status'    => 'Active',
            'password'  => Hash::make($input['password']),
        ]);
    }
}
