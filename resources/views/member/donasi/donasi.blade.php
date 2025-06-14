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
                        <div class="article-header">
                          
                           @if($donasi->foto && $donasi->foto !== 'default.jpg' && Storage::disk('public')->exists($donasi->foto))
                            <div class="article-image detail-donasi-image" data-background="{{ asset('storage/' . $donasi->foto) }}"> {{-- Tambah class 'detail-donasi-image' --}}
                            </div>
                        @else
                            <div class="article-image detail-donasi-image" data-background="{{ asset('assets/img/news/img13.jpg') }}"> {{-- Tambah class 'detail-donasi-image' --}}
                            </div>
                        @endif
                        </div>

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
                                {!! nl2br(e($donasi->deskripsi)) !!} {{-- nl2br untuk baris baru, e() untuk escaping HTML --}}
                            </div>

                                                        
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
                <form id="form-donasi"> {{-- action dan method akan dihandle oleh JavaScript (AJAX) --}}
                    @csrf
                    <input type="hidden" name="id_daftar_donasi" id="id_daftar_donasi" value="{{ $donasi->id }}">
                    <div class="form-group">
                        <label for="jumlah_donasi">Jumlah Donasi (Rp)</label>
                        <input type="number" class="form-control form-control-lg"
                               placeholder="Contoh: 50000" name="jumlah_donasi" id="jumlah_donasi"
                               min="10000" {{-- Contoh batas minimal donasi --}}
                               required>
                        <small class="form-text text-muted">Minimal donasi Rp10.000.</small>
                    </div>
                    {{-- Tambahkan field lain jika perlu, misal untuk pesan anonim, dll. --}}
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
{{-- JavaScript untuk menangani submit donasi dan Midtrans akan berada di myscript.js --}}
{{-- Pastikan myscript.js sudah di-include di footer layout Anda dan menangani klik #tombol-form-donasi --}}
{{-- Contoh event handler di myscript.js sudah pernah kita bahas dan Anda miliki --}}
<script>
    // Jika Anda ingin menambahkan JavaScript spesifik untuk halaman ini saja, bisa di sini.
    // Misalnya, untuk validasi input modal sebelum dikirim oleh myscript.js.
    // Namun, logika utama AJAX dan Midtrans sebaiknya tetap terpusat di myscript.js.

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('[data-background]').forEach(function (el) {
        el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')';
        el.style.backgroundSize = 'cover';
        el.style.backgroundPosition = 'center';
    });
});
</script>

    $(document).ready(function() {
    $('[data-background]').each(function() {
    var background = $(this).attr('data-background');
    $(this).css('background-image', 'url(' + background + ')');
});
        // Memastikan modal ditutup jika pembayaran berhasil atau dibatalkan
        // Ini mungkin sudah dihandle di logika myscript.js Anda,
        // tapi sebagai contoh jika Anda ingin interaksi spesifik di halaman ini.
        $('#donasiModal').on('hidden.bs.modal', function (e) {
            // Reset form jika diperlukan, atau aktifkan kembali tombol
            $('#form-donasi')[0].reset(); // Reset isi form
            $('#tombol-form-donasi').prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Lanjutkan Pembayaran');
        });
    });
</script>
@endpush

@push('styles')
<style>
    .article-style-c .article-description {
        margin-top: 15px;
        line-height: 1.8;
        color: #34395e;
    }

    .article-image.detail-donasi-image {
        height: 600px !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        border-radius: 10px;
    }

    .article-cta {
        margin-bottom: 40px;
    }
</style>
@endpush




