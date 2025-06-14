<?php

namespace App\Http\Controllers;

use App\Models\DaftarDonasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DaftarDonasiController extends Controller
{
    public function index()
    {
        return view('daftar-donasi.index', [
            'donasis' => DaftarDonasi::all()
        ]);
    }

    public function create()
    {
        return view('daftar-donasi.create', [
            'kategoris' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'judul' => 'required|max:255',
            'kategori_id' => 'required',
            'deskripsi' => 'required',
            'foto' => 'image|file|max:5000' // Foto bisa null saat create
        ]);

        if ($request->file('foto')) {
            $validateData['foto'] = $request->file('foto')->store('foto-donasi', 'public');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->deskripsi), 30);
        DaftarDonasi::create($validateData);

        return redirect('/dashboard/daftar-donasi')->with('alert', 'Data Berhasil Ditambah');
    }

    public function edit(DaftarDonasi $daftarDonasi)
    {
        return view('daftar-donasi.edit', [
            'daftar' => $daftarDonasi,
            'kategoris' => Kategori::all()
        ]);
    }

    public function update(Request $request, DaftarDonasi $daftarDonasi)
    {
        $rules = [
            'judul' => 'required|max:255',
            'kategori_id' => 'required',
            'deskripsi' => 'required',
            'foto' => 'image|file|max:5000'
        ];

        $validateData = $request->validate($rules);

        if ($request->file('foto')) {
            // Hapus foto lama jika ada
            if ($daftarDonasi->foto) {
                Storage::disk('public')->delete($daftarDonasi->foto);
            }
            // Simpan foto baru
            $validateData['foto'] = $request->file('foto')->store('foto-donasi', 'public');
        }

        $validateData['excerpt'] = Str::limit(strip_tags($request->deskripsi), 30);
        $daftarDonasi->update($validateData);

        return redirect('/dashboard/daftar-donasi')->with('alert', 'Data Berhasil Diupdate');
    }

    public function destroy(DaftarDonasi $daftarDonasi)
    {
        // Hapus foto jika ada
        if ($daftarDonasi->foto) {
            Storage::disk('public')->delete($daftarDonasi->foto);
        }
        
        $daftarDonasi->delete();
        return redirect('/dashboard/daftar-donasi')->with('alert', 'Data Berhasil Dihapus');
    }

    public function getTotalDonasi(DaftarDonasi $daftarDonasi)
    {
        // Menghitung total donasi dari relasi 'donasis'
        // Pastikan nama kolom untuk jumlah donasi di tabel 'donasis' Anda adalah 'jumlah'
        $total = $daftarDonasi->donasis()->sum('jumlah');

        return response()->json([
            'success' => true,
            'total_donasi' => $total
        ]);
    }

}
