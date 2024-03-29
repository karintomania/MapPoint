<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    //
    public function register()
    {
        return view('auth.register');
    }

    //
    public function store(Request $request, RegisterUser $registerUser)
    {
        $user = $registerUser($request->all());
        Auth::login($user);

        return redirect()->intended('/');
    }
}
