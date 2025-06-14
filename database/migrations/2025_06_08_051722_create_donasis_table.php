<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('kode_donasi');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('daftar_donasi_id');
            $table->string('snap_token');
            $table->integer('jumlah');
            $table->timestamp('waktu_donasi');
            $table->string('metode_pembayaran');
            $table->string('status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('daftar_donasi_id')->references('id')->on('daftar_donasis')->onDelete('cascade')->onUpdate('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('donasis');
    }
};