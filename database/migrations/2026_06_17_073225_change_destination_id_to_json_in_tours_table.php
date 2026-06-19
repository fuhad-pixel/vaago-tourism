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
        // Step 1: Add a temporary JSON column
        Schema::table('tours', function (Blueprint $table) {
            $table->json('new_destination_id')->nullable()->after('destination_id');
        });

        // Step 2: Migrate data to the new JSON column format
        // E.g., integer 1 becomes '["1"]'
        DB::statement('UPDATE tours SET new_destination_id = JSON_ARRAY(CAST(destination_id AS CHAR)) WHERE destination_id IS NOT NULL');

        // Step 3: Drop the foreign key and the old column
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });

        // Step 4: Rename the new column back to 'destination_id'
        Schema::table('tours', function (Blueprint $table) {
            $table->renameColumn('new_destination_id', 'destination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add a temporary bigInteger column
        Schema::table('tours', function (Blueprint $table) {
            $table->unsignedBigInteger('old_destination_id')->nullable()->after('destination_id');
        });

        // Step 2: Extract the first ID from JSON
        // Using JSON_EXTRACT to get the first element
        DB::statement("UPDATE tours SET old_destination_id = CAST(JSON_UNQUOTE(JSON_EXTRACT(destination_id, '$[0]')) AS UNSIGNED) WHERE destination_id IS NOT NULL AND JSON_LENGTH(destination_id) > 0");

        // Step 3: Drop the JSON column
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('destination_id');
        });

        // Step 4: Rename old column back
        Schema::table('tours', function (Blueprint $table) {
            $table->renameColumn('old_destination_id', 'destination_id');
        });

        // Step 5: Restore foreign key
        Schema::table('tours', function (Blueprint $table) {
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }
};
