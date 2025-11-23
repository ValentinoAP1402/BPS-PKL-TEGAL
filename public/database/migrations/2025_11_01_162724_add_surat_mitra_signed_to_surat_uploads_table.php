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
        Schema::table('surat_uploads', function (Blueprint $table) {
            $table->string('surat_mitra_signed')->nullable()->after('file_size');
        });

        // Migrate existing data from pendaftarans to surat_uploads
        DB::statement('
            UPDATE surat_uploads
            SET surat_mitra_signed = (
                SELECT surat_mitra_signed
                FROM pendaftarans
                WHERE pendaftarans.id = surat_uploads.pendaftaran_id
                LIMIT 1
            )
            WHERE surat_mitra_signed IS NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_uploads', function (Blueprint $table) {
            $table->dropColumn('surat_mitra_signed');
        });
    }
};
