<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DaftarDonasi;
use App\Models\Donasi;
use Illuminate\Support\Facades\DB;

class SyncTotalDonasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donasi:sync-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghitung ulang dan menyinkronkan total donasi di tabel daftar_donasi dari tabel donasi.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi total donasi...');

        // Ambil semua daftar donasi yang ada
        $daftarDonasiList = DaftarDonasi::all();

        foreach ($daftarDonasiList as $daftarDonasi) {
            // Hitung total donasi yang berhasil (settlement atau capture) untuk setiap daftar_donasi
            $total = Donasi::where('daftar_donasi_id', $daftarDonasi->id)
                           ->whereIn('status', ['settlement', 'capture'])
                           ->sum('jumlah');

            // Update kolom total_donasi di tabel daftar_donasi
            $daftarDonasi->total_donasi = $total;
            $daftarDonasi->save();

            $this->info("Total donasi untuk '{$daftarDonasi->judul}' telah diupdate menjadi: Rp" . number_format($total));
        }

        $this->info('Sinkronisasi selesai.');
        return 0;
    }
}
