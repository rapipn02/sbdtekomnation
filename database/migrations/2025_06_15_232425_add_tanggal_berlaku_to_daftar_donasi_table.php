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
        Schema::table('daftar_donasis', function (Blueprint $table) {
            // Tambahkan kolom tanggal_berlaku setelah kolom deskripsi
            $table->date('tanggal_berlaku')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_donasis', function (Blueprint $table) {
            $table->dropColumn('tanggal_berlaku');
        });
    }
};