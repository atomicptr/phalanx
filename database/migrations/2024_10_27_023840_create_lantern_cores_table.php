<?php

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
        Schema::create('lantern_cores', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('icon')->nullable(true);
            $table->string('active_icon')->nullable(true);
            $table->text('active')->nullable(true);
            $table->json('active_values');
            $table->text('passive')->nullable(true);
            $table->json('passive_values');

            $table->foreignIdFor(Patch::class, 'patch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lantern_cores');
    }
};
