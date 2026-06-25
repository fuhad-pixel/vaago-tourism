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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('title')->nullable()->after('exclusions');
            $table->string('banner_image')->nullable()->after('title');
            $table->integer('adults')->default(0)->after('banner_image');
            $table->integer('children')->default(0)->after('adults');
            $table->integer('infants')->default(0)->after('children');
        });

        Schema::table('quotation_days', function (Blueprint $table) {
            $table->unsignedBigInteger('start_point_id')->nullable();
            $table->unsignedBigInteger('end_point_id')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->string('room_type_name')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['title', 'banner_image', 'adults', 'children', 'infants']);
        });

        Schema::table('quotation_days', function (Blueprint $table) {
            $table->dropColumn(['start_point_id', 'end_point_id', 'hotel_id', 'room_type_id', 'room_type_name', 'driver_id', 'vehicle_id']);
        });
    }
};
