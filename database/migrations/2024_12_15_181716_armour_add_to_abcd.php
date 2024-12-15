<?php

use App\Models\Perk;
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
        Schema::table('armours', function (Blueprint $table) {
            $table->foreignIdFor(Perk::class, 'perkA')->constrained()->nullable(true)->default(null);
            $table->foreignIdFor(Perk::class, 'perkB')->constrained()->nullable(true)->default(null);
            $table->foreignIdFor(Perk::class, 'perkC')->constrained()->nullable(true)->default(null);
            $table->foreignIdFor(Perk::class, 'perkD')->constrained()->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('armours', function (Blueprint $table) {
            $table->dropForeignIdFor(Perk::class, 'perkA');
            $table->dropColumn('perkA');

            $table->dropForeignIdFor(Perk::class, 'perkB');
            $table->dropColumn('perkB');

            $table->dropForeignIdFor(Perk::class, 'perkC');
            $table->dropColumn('perkC');

            $table->dropForeignIdFor(Perk::class, 'perkD');
            $table->dropColumn('perkD');
        });
    }
};
