<?php

use App\Enums\ArmourType;
use App\Enums\Element;
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
        Schema::create('armours', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('type', ArmourType::values());
            $table->text('description')->nullable(true);
            $table->string('icon')->nullable(true);
            $table->enum('element', Element::values());
            $table->json('stats');

            $table->foreignIdFor(Patch::class, 'patch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armours');
    }
};
