<?php

use App\Enums\PerkType;
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
        Schema::table('perks', function (Blueprint $table) {
            $table->enum('type', PerkType::values());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perks', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
