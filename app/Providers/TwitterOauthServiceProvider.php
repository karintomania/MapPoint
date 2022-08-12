<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Abraham\TwitterOAuth\TwitterOAuth;

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
        $this->app->bind(TwitterOauth::class, function(){
            return new TwitterOauth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
            );
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
