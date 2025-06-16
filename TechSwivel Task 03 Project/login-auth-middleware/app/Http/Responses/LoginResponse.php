<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        $user = Auth::user();
        
        $redirectUrl = $user->role == 1 ? '/users' : '/home';

        return redirect()->intended($redirectUrl);
    }

}