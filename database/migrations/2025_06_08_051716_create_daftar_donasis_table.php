<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('daftar_donasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('excerpt');
            $table->integer('total_donasi')->default(0);
            $table->string('foto')->default('default.jpg');
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade')->onUpdate('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('daftar_donasis');
    }
};