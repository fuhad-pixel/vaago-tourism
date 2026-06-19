<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        // Seed default records
        DB::table('hero_settings')->insert([
            [
                'page_name' => 'destinations',
                'title' => 'Explore Destinations',
                'description' => 'Discover the most beautiful places in the world with us.',
                'image_path' => 'assets/img/bg/breadcrumb-bg.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_name' => 'blog',
                'title' => 'Latest News',
                'description' => 'Stay updated with our latest travels and tips.',
                'image_path' => 'assets/img/bg/breadcrumb-bg.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_name' => 'contact',
                'title' => 'Contact Us',
                'description' => 'Have questions? We would love to hear from you.',
                'image_path' => 'assets/img/bg/breadcrumb-bg.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_name' => 'tours',
                'title' => 'Explore Popular Trips',
                'description' => 'Check out our most exciting tour packages.',
                'image_path' => 'assets/img/bg/tours-breadcrumb-bg.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
