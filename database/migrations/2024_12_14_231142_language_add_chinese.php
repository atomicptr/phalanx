<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "alter table translations change column language language enum('en', 'de', 'es', 'fr', 'it', 'ja', 'pt', 'ru', 'zh', 'zx', 'tr', 'hu') not null"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            "alter table translations change column language language enum('en', 'de', 'es', 'fr', 'it', 'ja', 'pt', 'ru', 'tr', 'hu') not null"
        );
    }
};
