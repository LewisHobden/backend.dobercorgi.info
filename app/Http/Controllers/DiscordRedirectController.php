<?php

namespace App\Http\Controllers;

use Wohali\OAuth2\Client\Provider\Discord;

class DiscordRedirectController extends Controller
{
    /** @var Discord */
    private $provider = null;

    public function __construct(Discord $provider)
    {
        $this->provider = $provider;
    }

    public function __invoke()
    {
        $authUrl = $this->provider->getAuthorizationUrl();
        session(["oauthToken" => $this->provider->getState()]);

        return redirect($authUrl);
    }
}
