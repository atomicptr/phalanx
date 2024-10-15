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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false); // admins can do everything
            $table->boolean('can_publish')->default(false); // can set patches to "live" and trigger builds
            $table->boolean('can_access_confidential')->default(false); // can access confidential patches / data which is currently confidential
            $table->boolean('can_access_patches')->default(false); // can access the patches page and create new ones
            $table->boolean('can_edit_builds')->default(false); // can access the builds section and create/manage meta builds etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->dropColumn('can_publish');
            $table->dropColumn('can_access_confidential');
            $table->dropColumn('can_access_patches');
            $table->dropColumn('can_edit_builds');
        });
    }
};
