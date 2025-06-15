<?php

namespace App\Http\Controllers;

use App\Models\DaftarDonasi;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index()
    {
        // Mengambil data donatur terbanyak.
        $usersByTotalDonasi = Donasi::select('user_id')
            ->selectRaw('SUM(jumlah) as total_donasi')
            ->whereIn('status', ['settlement', 'capture'])
            ->groupBy('user_id')
            ->orderByDesc('total_donasi')
            ->get();
            
        return view('dashboard', [
            'data' => $usersByTotalDonasi,
            'user' => User::count(),
            'kategori' => Kategori::count(),
            'daftar' => DaftarDonasi::count(),
            'daftar_donasi' => DaftarDonasi::all()
        ]);
    }

    /**
     * Menyediakan data untuk grafik donasi.
     * Dapat memfilter berdasarkan kegiatan donasi jika ada parameter 'kegiatan_id'.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function grafik(Request $request)
    {
        // Query dasar untuk mengambil data donasi.
        $query = Donasi::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->whereIn('status', ['settlement', 'capture']);

        // --- PERUBAHAN DI SINI ---
        // Logika `if (Auth::user()->is_admin != 1)` yang memfilter berdasarkan user_id Dihapus.
        // Dengan ini, query akan mengambil data dari semua user, baik untuk admin maupun pengguna biasa.
        // --- AKHIR PERUBAHAN ---

        // Cek apakah ada input 'kegiatan_id' dari request AJAX dan tidak kosong.
        if ($request->filled('kegiatan_id')) {
            $query->where('daftar_donasi_id', $request->kegiatan_id);
        }

        // Eksekusi query setelah filter diterapkan.
        $donasiPerBulan = $query->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Memformat data untuk Chart.js (tidak ada perubahan di sini).
        $labels = $donasiPerBulan->pluck('bulan')->map(function ($bulan) {
            return Carbon::createFromFormat('Y-m', $bulan)->format('F Y');
        });
        
        $data = $donasiPerBulan->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Menyediakan data untuk kartu statistik berdasarkan filter bulan.
     * @param Request $request
     * @return array
     */
    public function filterDonasi(Request $request)
    {
        // Logika ini tetap membedakan antara admin dan pengguna untuk kartu statistik,
        // hanya grafik yang disamakan.
        if(Auth::user()->is_admin == 1){
            $bulan = $request->bulan;
            $tahun = date('Y');
        
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
        
            $totalDonasi = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['settlement', 'capture'])
                ->sum('jumlah');
        
            $jumlahPending = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'pending')
                ->count();
            
            $jumlahSettlement = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['settlement', 'capture'])
                ->count();
            
            $jumlahExpired = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'expire')
                ->count();
        
            return [
                'total_donasi' => $totalDonasi,
                'jumlah_pending' => $jumlahPending,
                'jumlah_settlement' => $jumlahSettlement,
                'jumlah_expired' => $jumlahExpired,
            ];

        } else {
            $userId = auth()->user()->id;
            $bulan = $request->bulan;
            $tahun = date('Y');
        
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
        
            $totalDonasi = Donasi::where('user_id', $userId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['settlement', 'capture'])
                ->sum('jumlah');
        
            $jumlahPending = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'pending')
                ->where('user_id', $userId)
                ->count();
            
            $jumlahSettlement = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['settlement', 'capture'])
                ->where('user_id', $userId)
                ->count();
            
            $jumlahExpired = Donasi::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'expire')
                ->where('user_id', $userId)
                ->count();
        
            return [
                'total_donasi' => $totalDonasi,
                'jumlah_pending' => $jumlahPending,
                'jumlah_settlement' => $jumlahSettlement,
                'jumlah_expired' => $jumlahExpired,
            ];
        }
    }
}