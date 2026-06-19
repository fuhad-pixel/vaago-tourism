<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\CompanySetting;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Tour;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock company setting and other essentials to avoid missing setting issues if any
        CompanySetting::create([
            'company_name' => 'Test Travel',
            'company_email' => 'test@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_destination_page_returns_successful_response(): void
    {
        // Create dynamic destinations
        Destination::create(['name' => 'Paris', 'description' => 'City of Lights']);
        Destination::create(['name' => 'Tokyo', 'description' => 'City of Neon']);

        $response = $this->get('/destination');
        $response->assertStatus(200);
        $response->assertSee('Paris');
        $response->assertSee('Tokyo');
    }

    public function test_tours_page_with_filters_returns_successful_response(): void
    {
        $dest = Destination::create(['name' => 'Maldives', 'description' => 'Beach paradise']);
        $cat = Category::create(['name' => 'Adventure', 'description' => 'Thrills']);

        $tour = Tour::create([
            'tour_code' => 'MALD01',
            'name' => 'Beautiful Maldives',
            'slug' => 'beautiful-maldives',
            'overview' => 'Maldives tour details',
            'category_id' => $cat->id,
            'destination_id' => $dest->id,
            'original_price' => 1500,
            'discount_price' => 1200,
            'duration_days' => 5,
            'duration_nights' => 4,
            'min_guests' => 2,
            'max_guests' => 10,
        ]);

        // Test general page
        $response = $this->get('/tours');
        $response->assertStatus(200);
        $response->assertSee('Beautiful Maldives');

        // Test filter by destination
        $response = $this->get('/tours?destination_id=' . $dest->id);
        $response->assertStatus(200);
        $response->assertSee('Beautiful Maldives');

        // Test filter by category
        $response = $this->get('/tours?category_id=' . $cat->id);
        $response->assertStatus(200);
        $response->assertSee('Beautiful Maldives');

        // Test filter by price limit
        $response = $this->get('/tours?price=2000');
        $response->assertStatus(200);
        $response->assertSee('Beautiful Maldives');

        // Test filter by search query
        $response = $this->get('/tours?search=Maldives');
        $response->assertStatus(200);
        $response->assertSee('Beautiful Maldives');

        // Test filter by non-matching query
        $response = $this->get('/tours?search=Switzerland');
        $response->assertStatus(200);
        $response->assertDontSee('Beautiful Maldives');
    }

    public function test_frontend_pages_display_dynamic_hero_settings(): void
    {
        // Update default hero settings in database
        \App\Models\HeroSetting::where('page_name', 'destinations')->update([
            'title' => 'Custom Destination Title',
            'description' => 'Custom Destination Subtitle'
        ]);
        \App\Models\HeroSetting::where('page_name', 'tours')->update([
            'title' => 'Custom Tours Title',
            'description' => 'Custom Tours Subtitle'
        ]);
        \App\Models\HeroSetting::where('page_name', 'blog')->update([
            'title' => 'Custom Blog Title',
            'description' => 'Custom Blog Subtitle'
        ]);
        \App\Models\HeroSetting::where('page_name', 'contact')->update([
            'title' => 'Custom Contact Title',
            'description' => 'Custom Contact Subtitle'
        ]);

        // Assert destinations page has custom titles
        $response = $this->get('/destination');
        $response->assertStatus(200);
        $response->assertSee('Custom Destination Title');
        $response->assertSee('Custom Destination Subtitle');

        // Assert tours page has custom titles
        $response = $this->get('/tours');
        $response->assertStatus(200);
        $response->assertSee('Custom Tours Title');
        $response->assertSee('Custom Tours Subtitle');

        // Assert blog page has custom titles
        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertSee('Custom Blog Title');
        $response->assertSee('Custom Blog Subtitle');

        // Assert contact page has custom titles
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Custom Contact Title');
        $response->assertSee('Custom Contact Subtitle');
    }

    public function test_admin_can_update_hero_settings(): void
    {
        // Create an admin user and authenticate
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/settings/hero', [
                'destinations_title' => 'Admin Updated Destinations',
                'destinations_description' => 'Admin Updated Destinations Subtitle',
                'blog_title' => 'Admin Updated Blogs',
                'blog_description' => 'Admin Updated Blogs Subtitle',
                'contact_title' => 'Admin Updated Contact',
                'contact_description' => 'Admin Updated Contact Subtitle',
                'tours_title' => 'Admin Updated Tours',
                'tours_description' => 'Admin Updated Tours Subtitle',
            ]);

        $response->assertStatus(302); // redirects back
        
        $this->assertDatabaseHas('hero_settings', [
            'page_name' => 'destinations',
            'title' => 'Admin Updated Destinations',
            'description' => 'Admin Updated Destinations Subtitle',
        ]);
        
        $this->assertDatabaseHas('hero_settings', [
            'page_name' => 'tours',
            'title' => 'Admin Updated Tours',
            'description' => 'Admin Updated Tours Subtitle',
        ]);
    }
}

