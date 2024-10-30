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
        Schema::table('lantern_cores', function (Blueprint $table) {
            $table->string('activeTitle')->nullable(true)->change();
            $table->string('passiveTitle')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lantern_cores', function (Blueprint $table) {
            $table->string('activeTitle')->nullable(false)->change();
            $table->string('passiveTitle')->nullable(false)->change();
        });
    }
};
