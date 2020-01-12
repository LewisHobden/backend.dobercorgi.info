<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class UserRepository implements UserRepositoryInterface
{
    /** @var User */
    private $user = null;

    /**
     * UserRepository constructor.
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param  DiscordResourceOwner  $discord
     * @return User
     */
    public function findOrCreateFromDiscord(DiscordResourceOwner $discord): User
    {
        $check = $this->user->where("discord_user_id",$discord->getId())->first();

        if(null !== $check)
            return $check;

        $this->user->fill([
           "name" => $discord->getUsername(),
           "email" => $discord->getEmail(),
           "discord_user_id" => $discord->getId()
        ])
        ->save();

        return $this->user;
    }
}
