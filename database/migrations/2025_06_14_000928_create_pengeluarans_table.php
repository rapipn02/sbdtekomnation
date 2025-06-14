<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_donasi_id')->constrained('daftar_donasis')->onDelete('cascade');
            
            // PERBAIKAN: Menyamakan nama kolom dengan yang ada di Controller dan Form
            $table->string('rincian');           // Sebelumnya: 'keterangan'
            $table->decimal('jumlah', 15, 2);  // Sebelumnya: 'jumlah_pengeluaran' dan tipenya integer
            $table->string('foto')->nullable();  // Sebelumnya: 'bukti_pengeluaran'
            // $table->date('tanggal_pengeluaran'); // Kolom ini bisa dihapus karena sudah ada timestamps

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluarans');
    }
};
