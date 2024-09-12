<?php

use App\Enums\Element;
use App\Enums\WeaponType;
use App\Models\Patch;
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

            $table->string('specialName')->nullable(true);
            $table->text('specialDescription')->nullable(true);
            $table->json('specialValues')->nullable(true);

            $table->string('passiveName')->nullable(true);
            $table->text('passiveDescription')->nullable(true);
            $table->json('passiveValues')->nullable(true);

            $table->string('activeName')->nullable(true);
            $table->text('activeDescription')->nullable(true);
            $table->json('activeValues')->nullable(true);

            $table->json('talents')->nullable(true);

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
