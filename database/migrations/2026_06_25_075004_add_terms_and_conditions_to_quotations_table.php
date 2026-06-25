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
            $table->text('terms_and_conditions')->nullable()->after('infants');
        });

        // Clean up existing quotation inclusions/exclusions against master lists
        try {
            $masterInclusions = \DB::table('additional_inclusions')->pluck('name')->toArray();
            $masterExclusions = \DB::table('additional_exclusions')->pluck('name')->toArray();

            $quotations = \DB::table('quotations')->get();
            foreach ($quotations as $quotation) {
                $inclusions = json_decode($quotation->inclusions, true) ?? [];
                $exclusions = json_decode($quotation->exclusions, true) ?? [];

                $filteredInclusions = array_values(array_intersect($inclusions, $masterInclusions));
                $filteredExclusions = array_values(array_intersect($exclusions, $masterExclusions));

                \DB::table('quotations')
                    ->where('id', $quotation->id)
                    ->update([
                        'inclusions' => json_encode($filteredInclusions),
                        'exclusions' => json_encode($filteredExclusions),
                    ]);
            }
        } catch (\Exception $e) {
            // Log or ignore if tables don't exist yet in a fresh setup
            \Log::warning("Could not clean up quotation inclusions/exclusions: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('terms_and_conditions');
        });
    }
};
