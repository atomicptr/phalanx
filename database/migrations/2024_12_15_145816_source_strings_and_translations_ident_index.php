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
        Schema::table('translations', function (Blueprint $table) {
            $table->index(['ident']);
            $table->unique(['ident', 'language']);
        });

        Schema::table('source_strings', function (Blueprint $table) {
            $table->index(['ident']);
            $table->unique(['ident']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('translations', function (Blueprint $table) {
            $table->dropIndex(['ident']);
            $table->dropUnique(['ident', 'language']);
        });

        Schema::table('source_strings', function (Blueprint $table) {
            $table->dropIndex(['ident']);
            $table->dropUnique(['ident']);
        });
    }
};
