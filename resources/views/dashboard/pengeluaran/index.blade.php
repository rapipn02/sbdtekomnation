{{-- File: resources/views/dashboard/pengeluaran/index.blade.php --}}
@extends('layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Pengeluaran Dana</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Pengeluaran</h4>
                <div class="card-header-action">
                    <a href="/dashboard/pengeluaran/create" class="btn btn-primary">Tambah Laporan Baru</a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kegiatan Donasi</th>
                                <th>Rincian Pengeluaran</th>
                                <th>Jumlah</th>
                                <th>Foto</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengeluarans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->daftarDonasi->judul }}</td>
                                <td>{{ $item->rincian }}</td>
                                <td>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Pengeluaran" width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

---
