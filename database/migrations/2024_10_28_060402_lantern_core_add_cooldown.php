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
        Schema::table('lantern_cores', fn (Blueprint $table) => $table->integer('activeCooldown', unsigned: true)->nullable(true));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lantern_cores', fn (Blueprint $table) => $table->dropColumn('activeCooldown'));
    }
};
