@extends('layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Form Laporan Pengeluaran</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="/dashboard/pengeluaran" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="daftar_donasi_id">Untuk Kegiatan Donasi</label>
                        <select name="daftar_donasi_id" id="daftar_donasi_id" class="form-control @error('daftar_donasi_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach ($daftar_donasi as $kegiatan)
                                <option value="{{ $kegiatan->id }}" {{ old('daftar_donasi_id') == $kegiatan->id ? 'selected' : '' }}>
                                    {{ $kegiatan->judul }}
                                </option>
                            @endforeach
                        </select>
                        @error('daftar_donasi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="rincian">Rincian Pengeluaran</label>
                        <textarea name="rincian" id="rincian" class="form-control @error('rincian') is-invalid @enderror" rows="3" required placeholder="Masukkan rincian pengeluaran...">{{ old('rincian') }}</textarea>
                        @error('rincian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Pengeluaran (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required min="1" step="1" placeholder="Masukkan jumlah pengeluaran">
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto/Struk Bukti (Opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Laporan
                        </button>
                        <a href="/dashboard/pengeluaran" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Pastikan script berjalan setelah halaman dimuat sepenuhnya
    document.addEventListener('DOMContentLoaded', function() {
        const kegiatanSelect = document.getElementById('daftar_donasi_id');
        const jumlahInput = document.getElementById('jumlah');

        // Fungsi ini akan dijalankan setiap kali pilihan kegiatan berubah
        kegiatanSelect.addEventListener('change', function() {
            const kegiatanId = this.value;

            // Jika user memilih opsi "-- Pilih Kegiatan --", kosongkan input
            if (!kegiatanId) {
                jumlahInput.value = '';
                jumlahInput.placeholder = 'Pilih kegiatan untuk memuat jumlah donasi';
                return;
            }

            // Tampilkan status loading agar user tahu ada proses berjalan
            jumlahInput.placeholder = 'Memuat total donasi...';

            // Panggil API yang sudah kita buat menggunakan Fetch API
            fetch(`/api/donasi/${kegiatanId}/total`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data dari server.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Jika berhasil, masukkan total donasi ke dalam input
                        jumlahInput.value = data.total_donasi;
                    } else {
                        jumlahInput.value = '';
                        jumlahInput.placeholder = 'Gagal memuat data.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    jumlahInput.value = '';
                    jumlahInput.placeholder = 'Terjadi kesalahan.';
                    alert('Gagal mengambil data total donasi. Silakan coba lagi.');
                });
        });

        // (Opsional) Jika ada nilai lama (misal saat validasi gagal), picu event 'change' saat halaman dimuat
        if (kegiatanSelect.value) {
            kegiatanSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

@endsection

