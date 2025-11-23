<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            DB::statement("ALTER TABLE pendaftarans CHANGE COLUMN status status ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            DB::statement("ALTER TABLE pendaftarans CHANGE COLUMN status status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
        });
    }
};
