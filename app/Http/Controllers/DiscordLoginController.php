<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordLoginController extends Controller
{
    /** @var Discord */
    private $provider       = null;
    /** @var UserRepositoryInterface */
    private $userRepository = null;

    /**
     * DiscordLoginController constructor.
     * @param  Discord  $provider
     * @param  UserRepositoryInterface  $repository
     */
    public function __construct(Discord $provider,UserRepositoryInterface $repository)
    {
        $this->provider = $provider;
        $this->userRepository = $repository;
    }

    /**
     * Handles the OAuth2 callback from Discord, logging the user in.
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            "code" => "required|string",
            "state" => "required|string"
        ]);

        if($request->query("state") !== $request->session()->get("oauthToken"))
            abort(403,"State has changed.");

        // Authenticate with OAuth2.
        $access_token = $this->provider->getAccessToken("authorization_code",["code" => $request->query("code")]);
        $resource_owner = $this->provider->getResourceOwner($access_token);

        // Log in or create the user from Discord.
        $user = $this->userRepository->findOrCreateFromDiscord($resource_owner);

        // Write permissions to the session.
        $permission_controller = new GuildPermissionController($this->provider,new Client());
        $permission_controller->setUser($user,$access_token);
        $permission_controller->cachePrivileges();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended("/");
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}
