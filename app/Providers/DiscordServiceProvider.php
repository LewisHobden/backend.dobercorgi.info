<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     * @var array
     */
    public $bindings = [
        AbstractProvider::class => Discord::class,
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(Discord::class,function($app) {
            $redirect  = url("login/discord-callback/");

            return new Discord([
                'clientId'     => env('DISCORD_CLIENT_ID'),
                'clientSecret' => env('DISCORD_CLIENT_SECRET'),
                'redirectUri'  => $redirect
            ]);
        });
    }
}
