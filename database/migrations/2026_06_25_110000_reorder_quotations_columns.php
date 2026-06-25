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
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE quotations MODIFY COLUMN title VARCHAR(255) NULL AFTER exclusions");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN banner_image VARCHAR(255) NULL AFTER title");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN adults INT NOT NULL DEFAULT 0 AFTER banner_image");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN children INT NOT NULL DEFAULT 0 AFTER adults");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN infants INT NOT NULL DEFAULT 0 AFTER children");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE quotations MODIFY COLUMN title VARCHAR(255) NULL AFTER deleted_at");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN banner_image VARCHAR(255) NULL AFTER title");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN adults INT NOT NULL DEFAULT 0 AFTER banner_image");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN children INT NOT NULL DEFAULT 0 AFTER adults");
            DB::statement("ALTER TABLE quotations MODIFY COLUMN infants INT NOT NULL DEFAULT 0 AFTER children");
        }
    }
};
