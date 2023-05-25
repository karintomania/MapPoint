<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\LoginUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request, LoginUser $loginUser)
    {
        $loginUser($request->all());

        // auth success
        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
