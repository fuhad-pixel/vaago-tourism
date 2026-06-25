<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('quotation_code')->unique()->after('id')->nullable();
        });

        // Populate existing quotations with codes
        $quotations = \DB::table('quotations')->whereNull('quotation_code')->get();
        foreach ($quotations as $quotation) {
            do {
                $code = 'VAAGO-' . strtoupper(Str::random(5));
            } while (\DB::table('quotations')->where('quotation_code', $code)->exists());

            \DB::table('quotations')
                ->where('id', $quotation->id)
                ->update(['quotation_code' => $code]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('quotation_code');
        });
    }
};
