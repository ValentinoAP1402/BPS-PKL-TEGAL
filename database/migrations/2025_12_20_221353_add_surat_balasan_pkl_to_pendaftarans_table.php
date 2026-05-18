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
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Cek apakah kolom lama ada, jika ada kita rename
            if (Schema::hasColumn('pendaftarans', 'surat_balasan')) {
                $table->renameColumn('surat_balasan', 'surat_balasan_pkl');
            }
            // Jika tidak ada keduanya, kita buat baru
            elseif (!Schema::hasColumn('pendaftarans', 'surat_balasan_pkl')) {
                $table->string('surat_balasan_pkl')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Kembalikan ke nama lama jika di-rollback
        if (Schema::hasColumn('pendaftarans', 'surat_balasan_pkl')) {
            $table->renameColumn('surat_balasan_pkl', 'surat_balasan');
        }
    });
    }
};
