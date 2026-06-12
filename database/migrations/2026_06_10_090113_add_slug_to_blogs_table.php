<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->after('title')->nullable();
        });

        // Auto-generate slugs for existing records
        $blogs = \Illuminate\Support\Facades\DB::table('blogs')->get();
        foreach ($blogs as $blog) {
            $slug = \Illuminate\Support\Str::slug($blog->title);
            
            // Check uniqueness
            $count = \Illuminate\Support\Facades\DB::table('blogs')->where('slug', $slug)->where('id', '!=', $blog->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . $blog->id;
            }

            \Illuminate\Support\Facades\DB::table('blogs')->where('id', $blog->id)->update(['slug' => $slug]);
        }

        // Now make it unique
        Schema::table('blogs', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
