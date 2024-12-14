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
        Schema::create('source_strings', function (Blueprint $table) {
            $table->id();

            $table->string('ident');
            $table->text('content');
            $table->string('model')->nullable(true)->default(null);
            $table->integer('modelId')->nullable(true)->default(null);
            $table->string('modelField')->nullable(true)->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_strings');
    }
};
