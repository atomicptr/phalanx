<?php

use App\Enums\Element;
use App\Enums\WeaponType;
use App\Models\Behemoth;
use App\Models\Patch;
use App\Models\WeaponAbility;
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
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('type', WeaponType::values());
            $table->text('description')->nullable(true);
            $table->string('icon')->nullable(true);

            $table->enum('element', Element::values());
            $table->foreignIdFor(WeaponAbility::class, 'special')->nullable(true);
            $table->foreignIdFor(WeaponAbility::class, 'passive')->nullable(true);
            $table->foreignIdFor(WeaponAbility::class, 'active')->nullable(true);

            $table->foreignIdFor(Behemoth::class, 'behemoth')->nullable(true);

            $table->foreignIdFor(Patch::class, 'patch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};
