<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDonatur extends Model
{
    use HasFactory;

    protected $table = 'jenis_donatur';
    protected $primaryKey = 'id_jenis'; // Mendefinisikan primary key
    public $incrementing = false; // Primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key adalah string

    protected $fillable = ['id_jenis', 'nama_jenis'];

    /**
     * Relasi one-to-many ke tabel User (Donatur)
     */
    public function users()
    {
        // Satu Jenis Donatur bisa dimiliki oleh banyak User
        return $this->hasMany(User::class, 'id_jenis', 'id_jenis');
    }
}