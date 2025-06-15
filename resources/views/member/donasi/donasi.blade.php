@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Detail Donasi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ url('/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ url('/user-donasi') }}">Donasi</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        @if(isset($donasi) && $donasi)
            <h2 class="section-title">Yuk, Bantu {{ $donasi->judul }}</h2>
            <p class="section-lead">Mari bersama-sama ulurkan tangan untuk saudara kita yang membutuhkan.</p>

            <div class="row">
                <div class="col-12">
                    <article class="article article-style-c">
                        {{-- WADAH GAMBAR --}}
                        <div class="article-header">
                            @if($donasi->foto && $donasi->foto !== 'default.jpg' && Storage::disk('public')->exists($donasi->foto))
                                {{-- Saya perbaiki 'class.' menjadi 'class=' dan menghapus style inline --}}
                                <div class="article-image detail-donasi-image" data-background="{{ asset('storage/' . $donasi->foto) }}">
                                </div>
                            @else
                                <div class="article-image detail-donasi-image" data-background="{{ asset('assets/img/news/img13.jpg') }}">
                                </div>
                            @endif
                        </div>

                        {{-- DETAIL ARTIKEL --}}
                        <div class="article-details">
                            <div class="article-category">
                                <a href="#">{{ $donasi->kategori->kategori ?? 'Tanpa Kategori' }}</a>
                                <div class="bullet"></div>
                                <a href="#">Total Terkumpul: Rp{{ number_format($donasi->total_donasi ?? 0, 0, ',', '.') }}</a>
                            </div>

                            <div class="article-title">
                                <h2><a href="#">{{ $donasi->judul }}</a></h2>
                            </div>

                            <div class="article-description">
                                {!! nl2br(e($donasi->deskripsi)) !!}
                            </div>
                            
                            {{-- LAPORAN PENGGUNAAN DANA --}}
                            <div class="mt-5">
                                <h4 class="section-title">Laporan Penggunaan Dana</h4>
                                @if($donasi->pengeluarans->isNotEmpty())
                                    <p class="section-lead">Berikut adalah rincian penggunaan dana yang telah terkumpul.</p>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Rincian</th>
                                                    <th>Jumlah</th>
                                                    <th>Bukti</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($donasi->pengeluarans as $pengeluaran)
                                                    <tr>
                                                        <td>{{ $pengeluaran->created_at->format('d M Y') }}</td>
                                                        <td>{{ $pengeluaran->rincian }}</td>
                                                        <td>Rp{{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if ($pengeluaran->foto)
                                                                <a href="{{ asset('storage/' . $pengeluaran->foto) }}" target="_blank">Lihat Foto</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <h2>Belum Ada Laporan</h2>
                                        <p class="lead">
                                            Saat ini belum ada laporan penggunaan dana yang diinput untuk kegiatan donasi ini.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- TOMBOL DONASI --}}
                            <div class="article-cta mt-4">
                                <button class="btn btn-success btn-lg" id="tombol-donasi" type="button"
                                        data-donasi-id="{{ $donasi->id }}" data-toggle="modal" data-target="#donasiModal">
                                    <i class="fas fa-hand-holding-usd"></i> Donasi Sekarang
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>

        @else
            <div class="alert alert-warning">
                <p>Informasi detail donasi tidak ditemukan atau tidak tersedia saat ini.</p>
                <a href="{{ url('/user-donasi') }}" class="btn btn-primary mt-2">Kembali ke Daftar Donasi</a>
            </div>
        @endif
    </div>
</section>

{{-- MODAL UNTUK DONASI --}}
@if(isset($donasi) && $donasi)
<div class="modal fade" tabindex="-1" role="dialog" id="donasiModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Berapa Anda Ingin Berdonasi?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-donasi">
                    @csrf
                    <input type="hidden" name="id_daftar_donasi" id="id_daftar_donasi" value="{{ $donasi->id }}">
                    <div class="form-group">
                        <label for="jumlah_donasi">Jumlah Donasi (Rp)</label>
                        <input type="number" class="form-control form-control-lg"
                               placeholder="Contoh: 50000" name="jumlah_donasi" id="jumlah_donasi"
                               min="10000"
                               required>
                        <small class="form-text text-muted">Minimal donasi Rp10.000.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="tombol-form-donasi">
                    <i class="fas fa-paper-plane"></i> Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Semua kode JavaScript untuk halaman ini digabung di sini
    $(document).ready(function() {
        
        // Kode untuk mengatur gambar background (ini sudah benar)
        document.querySelectorAll('[data-background]').forEach(function (el) {
            el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')';
        });

        // Kode untuk mereset modal setelah ditutup
        $('#donasiModal').on('hidden.bs.modal', function (e) {
            $('#form-donasi')[0].reset(); 
            $('#tombol-form-donasi').prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Lanjutkan Pembayaran');
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* KODE CSS FINAL YANG SUDAH DIPERBAIKI */
    .article-style-c .article-header {
        position: relative; 
        height: 500px; /* Atur tinggi wadah di sini */
        border-radius: 10px; /* Pindahkan radius ke pembungkus */
        overflow: hidden; /* Pastikan gambar tidak keluar dari radius */
    }

    .article-style-c .article-image.detail-donasi-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover !important;
    background-position: center !important;
}

.article-style-c .article-details {
    margin-top: 20px;
}
</style>
@endpush