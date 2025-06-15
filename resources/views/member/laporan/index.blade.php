@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Penggunaan Dana</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Laporan Penggunaan Dana</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Transparansi Dana</h2>
        <p class="section-lead">
            Berikut adalah rincian penggunaan dana dari semua kegiatan yang pernah Anda dukung.
        </p>
        <div class="card">
            <div class="card-header">
                <h4>Rincian Pengeluaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Untuk Kegiatan Donasi</th>
                                <th>Rincian</th>
                                <th>Jumlah</th>
                                <th>Tanggal Laporan</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengeluarans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->daftarDonasi->judul }}</td>
                                <td>{{ $item->rincian }}</td>
                                <td>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                               <td>
                                @if ($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Bukti" class="bukti-thumbnail">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada laporan penggunaan dana untuk donasi yang Anda ikuti.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
