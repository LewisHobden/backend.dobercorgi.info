<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Wohali\OAuth2\Client\Provider\Discord;

class DiscordLoginController extends Controller
{
    /** @var Discord */
    private $provider       = null;
    /** @var UserRepositoryInterface */
    private $userRepository = null;

    use AuthenticatesUsers;
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

    public function redirectPath()
    {
        return "/";
    }

    public function validateLogin(Request $request)
    {
        $request->validate([
            "code" => "required|string",
            "state" => "required|string"
        ]);

        if($request->query("state") !== $request->session()->get("oauthToken"))
            return abort(403,"State has changed.");
    }

    public function attemptLogin(Request $request)
    {
        // Authenticate with OAuth2.
        $access_token = $this->provider->getAccessToken("authorization_code",["code" => $request->query("code")]);
        $resource_owner = $this->provider->getResourceOwner($access_token);

        // Log in or create the user from Discord.
        $user = $this->userRepository->findOrCreateFromDiscord($resource_owner);

        // Write permissions to the session.
        $permission_controller = new GuildPermissionController($this->provider,new Client());
        $permission_controller->setUser($user,$access_token);
        $permission_controller->cachePrivileges();

        $this->guard()->login($user);

        return true;
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->intended("/");
    }
}
