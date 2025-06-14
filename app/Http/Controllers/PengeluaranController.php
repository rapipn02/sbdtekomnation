<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\DaftarDonasi;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        return view('dashboard.pengeluaran.index', [
            'pengeluarans' => Pengeluaran::with('daftarDonasi')->latest()->get()
        ]);
    }

    public function create()
    {
        return view('dashboard.pengeluaran.create', [
            'daftar_donasi' => DaftarDonasi::all()
        ]);
    }

    public function store(Request $request)
    {
        // PERBAIKAN UTAMA: Mengubah nama tabel di aturan validasi 'exists'
        // agar sesuai dengan nama tabel fisik di database ('daftar_donasis').
        $validatedData = $request->validate([
            'daftar_donasi_id' => 'required|exists:daftar_donasis,id', // <-- PERUBAHAN DI SINI
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'foto' => 'image|file|max:2048',
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('pengeluaran-foto', 'public');
        }

        Pengeluaran::create($validatedData);

        return redirect('/dashboard/pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function getKegiatanDetails(DaftarDonasi $daftarDonasi)
    {
        $totalPengeluaran = $daftarDonasi->pengeluarans()->sum('jumlah');
        $sisaSaldo = $daftarDonasi->total_donasi - $totalPengeluaran;

        return response()->json([
            'total_terkumpul' => (float) $daftarDonasi->total_donasi,
            'total_dikeluarkan' => (float) $totalPengeluaran,
            'sisa_saldo' => (float) $sisaSaldo,
        ]);
    }
}
