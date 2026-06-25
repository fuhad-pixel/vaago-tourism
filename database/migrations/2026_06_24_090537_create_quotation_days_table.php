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
        Schema::create('quotation_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->integer('day_number');
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->integer('distance')->nullable();
            $table->string('travel_time')->nullable();
            $table->longText('description')->nullable();
            
            // Accomodation
            $table->string('hotel_name')->nullable();
            $table->decimal('hotel_cost', 12, 2)->default(0);
            
            // Transport
            $table->string('vehicle_name')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('drop_location')->nullable();
            $table->integer('km_included')->nullable();
            $table->decimal('extra_km_charge', 12, 2)->default(0);
            $table->decimal('vehicle_cost', 12, 2)->default(0);
            
            // Extras
            $table->decimal('extra_charges', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);

            // JSON Arrays
            $table->json('highlights')->nullable();
            $table->json('activities')->nullable();
            $table->json('meals')->nullable();
            $table->json('images')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_days');
    }
};
