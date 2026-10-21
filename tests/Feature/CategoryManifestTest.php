<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryManifestTest extends TestCase
{
    use RefreshDatabase;

    public function testManifestListsCategoriesWithTheirResources(): void
    {
        Storage::fake();

        $categoryId = DB::table('resource_categories')->insertGetId([
            'title' => 'Guides',
            'icon' => 'book',
            'description' => 'Some guides',
        ]);

        DB::table('resource_categories')->insert([
            'title' => 'Deleted',
            'icon' => 'trash',
            'description' => 'Soft deleted',
            'deleted_at' => now(),
        ]);

        $withImage = DB::table('resources')->insertGetId([
            'category_id' => $categoryId,
            'title' => 'With image',
            'content' => 'Content A',
            'action' => 'https://example.com/a',
            'file_key' => 'category/1/resource/a.png',
        ]);

        $withoutImage = DB::table('resources')->insertGetId([
            'category_id' => $categoryId,
            'title' => 'Without image',
            'content' => 'Content B',
            'action' => 'https://example.com/b',
            'file_key' => '',
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJson([
            [
                'id' => $categoryId,
                'title' => 'Guides',
                'icon' => 'book',
                'description' => 'Some guides',
                'items' => [
                    [
                        'id' => $withImage,
                        'title' => 'With image',
                        'content' => 'Content A',
                        'action' => 'https://example.com/a',
                    ],
                    [
                        'id' => $withoutImage,
                        'title' => 'Without image',
                        'content' => 'Content B',
                        'action' => 'https://example.com/b',
                    ],
                ],
            ],
        ]);

        $items = $response->json('0.items');
        $this->assertStringEndsWith('category/1/resource/a.png', $items[0]['imageUrl']);
        $this->assertArrayNotHasKey('imageUrl', $items[1]);
    }

    public function testManifestRequestIsLogged(): void
    {
        $this->getJson('/api/categories')->assertOk();

        $this->assertSame(1, DB::table('manifest_requests')->count());
        $this->assertSame('127.0.0.1', DB::table('manifest_requests')->value('ip_address'));
    }
}
