<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->unsignedInteger('duration_days')->default(0)->after('price_type');
            $table->unsignedInteger('duration_nights')->default(0)->after('duration_days');
            $table->unsignedInteger('duration_hours')->default(0)->after('duration_nights');
            $table->unsignedInteger('duration_minutes')->default(0)->after('duration_hours');
            $table->unsignedInteger('min_guests')->nullable()->after('duration_minutes');
            $table->unsignedInteger('max_guests')->nullable()->after('min_guests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'duration_days',
                'duration_nights',
                'duration_hours',
                'duration_minutes',
                'min_guests',
                'max_guests'
            ]);
        });
    }
};
