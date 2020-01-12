<?php

namespace App\Repositories\Interfaces;

use App\User;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

interface UserRepositoryInterface
{
    public function __construct(User $user);

    public function findOrCreateFromDiscord(DiscordResourceOwner $discord) : User;
}
