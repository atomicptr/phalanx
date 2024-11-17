<?php

use App\Enums\BuildCategory;
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
        Schema::create('builds', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('buildId');
            $table->text('description')->nullable();
            $table->string('youtube')->nullable();

            $table->enum('buildCategory', BuildCategory::values());

            $table->foreignIdFor(Patch::class, 'patch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builds');
    }
};
