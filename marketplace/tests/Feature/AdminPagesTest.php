<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    /**
     * @dataProvider adminPageProvider
     */
    public function test_admin_pages_load_successfully(string $uri): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get($uri);

        $response->assertOk();
    }

    public static function adminPageProvider(): array
    {
        return [
            'dashboard redirect' => ['/admin'],
            'categories index' => ['/admin/categories'],
            'products index' => ['/admin/products'],
            'vendors index' => ['/admin/vendors'],
            'orders index' => ['/admin/orders'],
            'sliders index' => ['/admin/sliders'],
            'banners index' => ['/admin/banners'],
            'site settings' => ['/admin/settings/site'],
            'payment settings' => ['/admin/settings/payment'],
        ];
    }
}
