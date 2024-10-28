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
            $table->renameColumn('active_icon', 'activeIcon');
            $table->renameColumn('active_values', 'activeValues');
            $table->renameColumn('passive_values', 'passiveValues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lantern_cores', function (Blueprint $table) {
            $table->renameColumn('activeIcon', 'active_icon');
            $table->renameColumn('activeValues', 'active_values');
            $table->renameColumn('passiveValues', 'passive_values');
        });
    }
};
