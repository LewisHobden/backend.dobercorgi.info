<?php

namespace App\Repositories;

use App\User;
use PHPUnit\Framework\TestCase;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class UserRepositoryTest extends TestCase
{
    public function testFindOrCreateFromDiscordWhenUserDoesNotExist()
    {
        $owner = new DiscordResourceOwner([
            "id" => "12345",
            "username" => "Test",
            "email" => "test@email.com"
        ]);

        $user = \Mockery::mock(User::class);
        $user->expects("where")->once()->with("discord_user_id","12345")->andReturn($user);
        $user->expects("first")->once()->withNoArgs()->andReturnNull();
        $user->expects("fill")->once()->with([
            "name" => "Test",
            "email" => "test@email.com",
            "discord_user_id" => "12345"
        ])
        ->andReturn($user);

        $user->expects("save")->once()->withNoArgs()->andReturnNull();

        $repo = new UserRepository($user);
        $this->assertEquals($user,$repo->findOrCreateFromDiscord($owner));

    }

    public function testFindOrCreateFromDiscordWhenUser()
    {
        $owner = new DiscordResourceOwner([
            "id" => "12345",
            "username" => "Test",
            "email" => "test@email.com"
        ]);

        $user = \Mockery::mock(User::class);
        $user->expects("where")->once()->with("discord_user_id","12345")->andReturn($user);
        $user->expects("first")->once()->withNoArgs()->andReturn($user);

        $repo = new UserRepository($user);
        $this->assertEquals($user,$repo->findOrCreateFromDiscord($owner));
    }
}
