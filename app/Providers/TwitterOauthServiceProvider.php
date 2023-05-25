<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class TwitterOauthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(TwitterOauth::class, function () {
            $twitterOAuth = new TwitterOauth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
            );

            // if user is logged in by twitter, set token
            if (Auth::check() && ! empty(Auth::user()->twitter_id)) {
                $user = Auth::user();
                $twitterOAuth->setOauthToken($user->twitter_token, $user->twitter_token_secret);
            }

            return $twitterOAuth;
        });
    }
}
