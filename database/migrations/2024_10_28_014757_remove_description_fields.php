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
        Schema::table('weapons', fn (Blueprint $table) => $table->dropColumn('description'));
        Schema::table('armours', fn (Blueprint $table) => $table->dropColumn('description'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weapons', fn (Blueprint $table) => $table->text('description')->nullable(true));
        Schema::table('armours', fn (Blueprint $table) => $table->text('description')->nullable(true));
    }
};
