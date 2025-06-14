<?php

namespace App\Http\Controllers;

use App\Models\DaftarDonasi;
use App\Models\Donasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pengeluaran;

class MemberController extends Controller
{
    public function index()
    {
        return \view('member.donasi.index', [
            'donasis' => DaftarDonasi::latest()->filter(\request(['cari', 'kat']))->paginate(4)->withQueryString(),
            'kategoris' => Kategori::all()
        ]);
    }

    public function show(DaftarDonasi $daftardonasi)
    {
        return \view('member.donasi.donasi', [
            'donasi' => $daftardonasi
        ]);
    }

    public function kirimDonasi(Request $request)
    {
        $daftardonasi = DaftarDonasi::find($request->id_daftar_donasi);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $payload = [
            'transaction_details' => [
                'order_id' => 'IDonation-' . \uniqid(),
                'gross_amount' => $request->jumlah_donasi,
            ],
            'customer_details' => [
                'first_name' =>  Auth::user()->name,
                'email' => Auth::user()->email
            ],
            'item_details' => [
                [
                    'id' => $daftardonasi->id,
                    'price' => $request->jumlah_donasi,
                    'quantity' => 1,
                    'name' => $daftardonasi->judul
                ]
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        $response = [
            'idDonasi' => $daftardonasi->id,
            'snapToken' => $snapToken
        ];
        return $response;
    }

    public function notifikasi(Request $request)
    {
        $transaksi = $request->response; //sudah jadi array assoc
        $idDonasi = $request->idDonasi;
        //simpan data ke tabel donasi
        $donasi = Donasi::create([
            'order_id' => $transaksi['order_id'],
            'kode_donasi' => 'DNS -' . \date('Ymd') . Str::random(3),
            'user_id' => Auth::user()->id,
            'daftar_donasi_id' => $idDonasi,
            'snap_token' => $request->snapToken,
            'jumlah' => $transaksi['gross_amount'],
            'waktu_donasi' => $transaksi['transaction_time'],
            'metode_pembayaran' => $transaksi['payment_type'],
            'status' => $transaksi['transaction_status']
        ]);

        // PERBAIKAN: Logika penambahan total donasi dihapus dari sini
        // dan dipindahkan ke method callback agar lebih akurat.

        return $donasi->kode_donasi;
    }

    public function invoice()
    {
        return \view('member.riwayat.invoice', [
            'invoices' => Donasi::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function invoiceDetail($kode)
    {
        return \view('member.riwayat.detail', [
            'invoice' => Donasi::where('kode_donasi', $kode)->first(),
        ]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = \hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $donasi = Donasi::where('order_id', $request->order_id)->first();

            if ($donasi) {
                // Jika transaksi berhasil (settlement atau capture)
                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    // Update status transaksi
                    $donasi->update(['status' => $request->transaction_status]);

                    // --- LOGIKA BARU UNTUK SINKRONISASI TOTAL ---
                    $daftarDonasi = DaftarDonasi::find($donasi->daftar_donasi_id);
                    if ($daftarDonasi) {
                        // Hitung ulang total donasi yang berhasil untuk kegiatan ini
                        $totalBaru = Donasi::where('daftar_donasi_id', $daftarDonasi->id)
                            ->whereIn('status', ['settlement', 'capture'])
                            ->sum('jumlah');

                        // Update total_donasi di tabel daftar_donasi
                        $daftarDonasi->update(['total_donasi' => $totalBaru]);
                    }
                }
                // Jika transaksi gagal atau kadaluarsa
                else if (
                    $request->transaction_status == 'cancel' ||
                    $request->transaction_status == 'deny' ||
                    $request->transaction_status == 'expire'
                ) {
                    $donasi->update(['status' => $request->transaction_status]);
                }
                // Jika masih pending
                else if ($request->transaction_status == 'pending') {
                    $donasi->update(['status' => 'pending']);
                }
            }
        }
    }

    public function printInvoice($kode)
    {
        $data = Donasi::where('kode_donasi', $kode)->get();
        $pdf = Pdf::loadView('member.riwayat.print', [
            'data' => $data
        ]);
        return $pdf->stream('invoice.pdf');
    }

    public function laporanPengeluaran()
    {
        // 1. Dapatkan ID dari semua kampanye donasi yang telah diikuti oleh user
        $donatedCampaignIds = Donasi::where('user_id', Auth::id())
                                    ->whereIn('status', ['settlement', 'capture'])
                                    ->pluck('daftar_donasi_id')
                                    ->unique();

        // 2. Dapatkan semua data pengeluaran yang terkait dengan kampanye tersebut
        $pengeluarans = Pengeluaran::whereIn('daftar_donasi_id', $donatedCampaignIds)
                                   ->with('daftarDonasi') // Eager load untuk menampilkan judul kegiatan
                                   ->latest()
                                   ->get();

        // 3. Kirim data ke view baru
        return view('member.laporan.index', [
            'pengeluarans' => $pengeluarans
        ]);
    }
}
