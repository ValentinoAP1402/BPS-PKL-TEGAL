<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- INI YANG SEBELUMNYA KURANG

class CreateAlertMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alert_messages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('message');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default data
        DB::table('alert_messages')->insert([
            'key' => 'pkl_warning',
            // Saya juga perbaiki typo 'MASIK' menjadi 'MASIH' di bawah ini:
            'message' => 'PKL INI UNTUK SISWA/SISWI YANG MASIH SEKOLAH ATAU MASIH KULIAH',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_messages');
    }
}