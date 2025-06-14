<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarDonasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Pastikan baris ini sudah ada dan benar
    protected $table = 'daftar_donasis';

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    
    // Relasi ke Pengeluaran
    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'daftar_donasi_id');
    }

    public function donasis()
    {
        // Pastikan 'daftar_donasi_id' adalah foreign key yang benar di tabel 'donasis'
        return $this->hasMany(Donasi::class, 'daftar_donasi_id');
    }

    // Fungsi scope untuk filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->where('judul', 'like', '%' . $cari . '%');
        });

        $query->when($filters['kat'] ?? false, function ($query, $kategori) {
            return $query->whereHas('kategori', function ($query) use ($kategori) {
                $query->where('id', $kategori);
            });
        });
    }
}
