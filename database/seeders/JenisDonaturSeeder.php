<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisDonatur;

class JenisDonaturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Parameter pertama: kondisi pencarian
        // Parameter kedua: data yang akan di-create atau di-update
        JenisDonatur::updateOrCreate(
            ['id_jenis' => 'JD01'],
            ['nama_jenis' => 'Kelas']
        );
        JenisDonatur::updateOrCreate(
            ['id_jenis' => 'JD02'],
            ['nama_jenis' => 'Organisasi']
        );
        JenisDonatur::updateOrCreate(
            ['id_jenis' => 'JD03'],
            ['nama_jenis' => 'Umum']
        );
    }
}