<?php

namespace App\Http\Controllers\Auth;

use App\Actions\TwitterAuth\CreateTwitterAuthUrl;
use App\Actions\TwitterAuth\FetchAccessToken;
use App\Actions\TwitterAuth\LoginTwitterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwitterAuthController extends Controller{

    public function login (CreateTwitterAuthUrl $createTwitterAuthUrl){

        $url = $createTwitterAuthUrl();

        return redirect($url);
    }

    public function redirect(Request $request, LoginTwitterUser $loginTwitterUser){

        $user = $loginTwitterUser($request->all());

        return redirect('/');

    }
}