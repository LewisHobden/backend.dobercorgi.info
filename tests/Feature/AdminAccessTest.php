<?php

namespace Tests\Feature;

use App\Enums\DiscordPermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestIsRedirectedToLogin(): void
    {
        $this->get('/categories')->assertRedirect('/login');
        $this->get('/categories/1/resources')->assertRedirect('/login');
    }

    public function testUserWithoutPermissionIsForbidden(): void
    {
        $this->logIn();

        $this->withSession(['guild_permissions' => DiscordPermissions::ADMINISTRATOR])
            ->get('/categories')
            ->assertForbidden();
    }

    public function testUserWithPermissionCanManageCategories(): void
    {
        $this->logIn();
        $this->withSession(['guild_permissions' => DiscordPermissions::MANAGE_WEBHOOKS | DiscordPermissions::ADMINISTRATOR]);

        $this->get('/categories')->assertOk();

        $this->post('/categories', ['title' => 'New', 'icon' => 'star', 'description' => 'Desc'])
            ->assertRedirect('/categories')
            ->assertSessionHas('success');

        $categoryId = DB::table('resource_categories')->where('title', 'New')->value('id');
        $this->assertNotNull($categoryId);

        $this->get("/categories/{$categoryId}/edit")->assertOk();
        $this->get("/categories/{$categoryId}/resources")->assertOk();
        $this->get("/categories/{$categoryId}/resources/create")->assertOk();

        $this->post("/categories/{$categoryId}/resources", [
            'title' => 'Resource',
            'action' => 'https://example.com',
            'content' => 'Body',
        ])->assertRedirect("/categories/{$categoryId}/resources");

        $this->assertSame(1, DB::table('resources')->where('category_id', $categoryId)->count());

        $this->delete("/categories/{$categoryId}")->assertRedirect('/categories');
        $this->assertNotNull(DB::table('resource_categories')->where('id', $categoryId)->value('deleted_at'));
    }

    private function logIn(): void
    {
        $id = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'discord_user_id' => '12345',
        ]);

        Auth::loginUsingId($id);
    }
}
