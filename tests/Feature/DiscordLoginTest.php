<?php

namespace Tests\Feature;

use Tests\TestCase;

class DiscordLoginTest extends TestCase
{
    public function testLoginRedirectsToDiscordAndStoresState(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect();
        $this->assertStringContainsString('oauth2/authorize', $response->headers->get('Location'));
        $response->assertSessionHas('oauthToken');
    }

    public function testCallbackRejectsMismatchedState(): void
    {
        $this->withSession(['oauthToken' => 'expected'])
            ->get('/login/discord-callback?code=abc&state=wrong')
            ->assertForbidden();
    }
}
