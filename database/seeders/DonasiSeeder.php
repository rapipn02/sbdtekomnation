<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donasi;
use App\Models\User;
use App\Models\DaftarDonasi;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DonasiSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     *
     * @return void
     */
    public function run()
    {
        // Tips: Kosongkan tabel donasi agar tidak ada data duplikat jika seeder dijalankan lagi
        // Hati-hati jika Anda sudah punya data donasi asli.
        // Donasi::truncate(); 

        // Ambil semua user dan daftar_donasi yang ada untuk dijadikan referensi
        $users = User::all();
        $daftarDonasi = DaftarDonasi::all();

        // Hentikan seeder jika tidak ada user atau daftar donasi yang bisa dijadikan referensi
        if ($users->isEmpty() || $daftarDonasi->isEmpty()) {
            $this->command->info('Tidak dapat menjalankan DonasiSeeder karena tidak ada data User atau DaftarDonasi.');
            $this->command->info('Pastikan Anda sudah memiliki data di tabel users dan daftar_donasi.');
            return;
        }

        $this->command->info('Membuat 50 data donasi palsu...');

        // Loop untuk membuat 50 data donasi
        for ($i = 0; $i < 50; $i++) {
            
            // Buat tanggal donasi secara acak dalam rentang 250 hari terakhir
            $tanggalDonasi = Carbon::now()->subDays(rand(0, 250));

            Donasi::create([
                'order_id' => 'IDonation-Seed-' . uniqid(),
                'kode_donasi' => 'DNS-SEED-' . $tanggalDonasi->format('Ymd') . Str::random(3),
                'user_id' => $users->random()->id, // Pilih user secara acak
                'daftar_donasi_id' => $daftarDonasi->random()->id, // Pilih target donasi secara acak
                'snap_token' => Str::random(36),
                'jumlah' => rand(2, 50) * 10000, // Jumlah donasi acak antara Rp 20.000 - Rp 500.000
                'waktu_donasi' => $tanggalDonasi,
                'metode_pembayaran' => ['bank_transfer', 'gopay', 'qris'][rand(0, 2)], // Pilih metode secara acak
                'status' => ['settlement', 'capture'][rand(0, 1)], // Pilih status secara acak (keduanya akan terhitung di grafik)
                'created_at' => $tanggalDonasi,
                'updated_at' => $tanggalDonasi,
            ]);
        }

        $this->command->info('Seeding 50 data donasi selesai.');
    }
}
