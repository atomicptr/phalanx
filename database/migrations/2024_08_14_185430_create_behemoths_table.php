<?php

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
        Schema::create('behemoths', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable(true);
            $table->enum('element', Element::values());
            $table->string('icon')->nullable(true);

            $table->foreignIdFor(Patch::class, 'patch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behemoths');
    }
};
