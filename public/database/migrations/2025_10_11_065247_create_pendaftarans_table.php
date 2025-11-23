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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
        $table->string('nama_lengkap');
        $table->string('asal_sekolah');
        $table->string('jurusan');
        $table->string('email')->unique();
        $table->string('no_hp');
        $table->string('surat_keterangan_pkl'); // Path file
        $table->date('tanggal_mulai_pkl');
        $table->date('tanggal_selesai_pkl');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
