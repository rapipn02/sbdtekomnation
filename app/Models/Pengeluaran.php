<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke DaftarDonasi (kegiatan).
     * Sebuah pengeluaran pasti milik satu kegiatan donasi.
     */
    public function daftarDonasi()
    {
        return $this->belongsTo(DaftarDonasi::class, 'daftar_donasi_id');
    }
}
