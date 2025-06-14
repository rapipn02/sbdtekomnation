@extends('layouts.app')

@section('content')

{{-- ================================================================= --}}
{{-- ===================== TAMPILAN UNTUK ADMIN ====================== --}}
{{-- ================================================================= --}}
@can('admin')
<section class="section">
    {{-- Kartu Statistik dengan Filter Bulan --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Hasil Donasi -
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">Pilih Bulan</a>
                            <ul class="dropdown-menu dropdown-menu-sm">
                                <li class="dropdown-item" data-bulan="1">Januari</li>
                                <li class="dropdown-item" data-bulan="2">Febuari</li>
                                <li class="dropdown-item" data-bulan="3">Maret</li>
                                <li class="dropdown-item" data-bulan="4">April</li>
                                <li class="dropdown-item" data-bulan="5">Mei</li>
                                <li class="dropdown-item" data-bulan="6">Juni</li>
                                <li class="dropdown-item" data-bulan="7">Juli</li>
                                <li class="dropdown-item" data-bulan="8">Agustus</li>
                                <li class="dropdown-item" data-bulan="9">September</li>
                                <li class="dropdown-item" data-bulan="10">Oktober</li>
                                <li class="dropdown-item" data-bulan="11">November</li>
                                <li class="dropdown-item" data-bulan="12">Desember</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="paid">0</div>
                            <div class="card-stats-item-label">Terbayar</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="pending">0</div>
                            <div class="card-stats-item-label">Belum Bayar</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="expire">0</div>
                            <div class="card-stats-item-label">Kadaluarsa</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Donasi</h4>
                    </div>
                    <div class="card-body" id="total-donasi">
                        Rp0
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Info Cepat --}}
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>User</h4>
                    </div>
                    <div class="card-body">
                        {{$user}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kategori Donasi</h4>
                    </div>
                    <div class="card-body">
                        {{$kategori}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Daftar Donasi</h4>
                    </div>
                    <div class="card-body">
                        {{$daftar}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Grafik dengan Filter Kegiatan --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Jumlah Donasi</h4>
                    <div class="card-header-action">
                        <select class="form-control" id="filter-kegiatan">
                            <option value="">Semua Kegiatan</option>
                            @foreach ($daftar_donasi as $kegiatan)
                                <option value="{{ $kegiatan->id }}">{{ $kegiatan->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donasiChart" height="158"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Donatur Terbanyak --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar User Terbanyak Donasi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-invoice p-2">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>Rp{{ number_format($item->total_donasi, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endcan


{{-- =================================================================== --}}
{{-- ===================== TAMPILAN UNTUK PENGGUNA ===================== --}}
{{-- =================================================================== --}}
@can('pengguna')
<section class="section">
    {{-- Kartu Statistik dengan Filter Bulan (untuk pengguna) --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Hasil Donasi {{ Auth::user()->name }} -
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">Pilih Bulan</a>
                            <ul class="dropdown-menu dropdown-menu-sm">
                                <li class="dropdown-item" data-bulan="1">Januari</li>
                                <li class="dropdown-item" data-bulan="2">Febuari</li>
                                <li class="dropdown-item" data-bulan="3">Maret</li>
                                <li class="dropdown-item" data-bulan="4">April</li>
                                <li class="dropdown-item" data-bulan="5">Mei</li>
                                <li class="dropdown-item" data-bulan="6">Juni</li>
                                <li class="dropdown-item" data-bulan="7">Juli</li>
                                <li class="dropdown-item" data-bulan="8">Agustus</li>
                                <li class="dropdown-item" data-bulan="9">September</li>
                                <li class="dropdown-item" data-bulan="10">Oktober</li>
                                <li class="dropdown-item" data-bulan="11">November</li>
                                <li class="dropdown-item" data-bulan="12">Desember</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="paid">0</div>
                            <div class="card-stats-item-label">Terbayar</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="pending">0</div>
                            <div class="card-stats-item-label">Belum Bayar</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count" id="expire">0</div>
                            <div class="card-stats-item-label">Kadaluarsa</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Donasi Anda</h4>
                    </div>
                    <div class="card-body" id="total-donasi">
                        Rp0
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Grafik (untuk pengguna tidak perlu filter kegiatan) --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Jumlah Seluruh Donasi</h4>
                </div>
                <div class="card-body">
                    <canvas id="donasiChart" height="158"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
@endcan
@endsection


{{-- =================================================================== --}}
{{-- ========================== SEMUA SCRIPT =========================== --}}
{{-- =================================================================== --}}
@push('scripts')
<script src="{{ asset('node_modules/chart.js/dist/Chart.min.js') }}"></script>
<script>
// Variabel untuk menyimpan instance chart, agar bisa dihancurkan sebelum menggambar ulang.
let donasiChartInstance = null;

/**
 * Fungsi untuk memformat angka menjadi format 'K' (ribu) atau 'Jt' (juta).
 * @param {number} value Angka yang akan diformat.
 * @returns {string} Angka yang sudah diformat.
 */
function formatKeSatuan(value) {
    if (value >= 1000000) {
        // Handle angka desimal, tampilkan 1 angka di belakang koma jika perlu.
        const formattedValue = (value / 1000000).toFixed(1).replace(/\.0$/, '');
        return 'Rp' + formattedValue + ' Jt';
    }
    if (value >= 1000) {
        const formattedValue = (value / 1000).toFixed(1).replace(/\.0$/, '');
        return 'Rp' + formattedValue + ' K';
    }
    return 'Rp' + value;
}

/**
 * Fungsi untuk mengambil data dan menggambar chart.
 * Menerima ID kegiatan sebagai parameter opsional untuk filtering.
 * @param {string|null} kegiatanId ID dari kegiatan donasi yang dipilih.
 */
function drawDonasiChart(kegiatanId = null) {
    // URL menunjuk ke route controller 'grafik'.
    let url = new URL("{{ route('donasi.grafik') }}");
    
    // Jika ada ID kegiatan yang dipilih, tambahkan sebagai parameter 'kegiatan_id'.
    if (kegiatanId) {
        url.searchParams.append('kegiatan_id', kegiatanId);
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const ctx = document.getElementById('donasiChart').getContext('2d');

            // Hancurkan chart yang lama jika ada, untuk mencegah tumpukan grafik.
            if (donasiChartInstance) {
                donasiChartInstance.destroy();
            }

            // Buat instance chart yang baru dengan data yang diterima.
            donasiChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Total Donasi',
                        data: data.data,
                        borderWidth: 2,
                        backgroundColor: '#015D2E',
                        borderColor: '#015D2E',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: '#015D2E',
                    }]
                },
                // --- PERUBAHAN DI SINI UNTUK KOMPATIBILITAS CHART.JS v2 ---
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true // Menampilkan label 'Total Donasi'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // Gunakan fungsi formatter untuk label di sumbu Y.
                                callback: function(value, index, values) {
                                    return formatKeSatuan(value);
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            // Gunakan formatter juga untuk tooltip saat di-hover.
                            label: function(tooltipItem, data) {
                                let label = data.datasets[tooltipItem.datasetIndex].label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += formatKeSatuan(tooltipItem.yLabel);
                                return label;
                            }
                        }
                    }
                }
                // --- AKHIR PERUBAHAN ---
            });
        })
        .catch(error => console.error('Gagal memuat data grafik:', error));
}

// -- Skrip ini akan berjalan setelah seluruh halaman dimuat --
document.addEventListener("DOMContentLoaded", function() {
    // 1. Gambar chart untuk pertama kali (menampilkan data "Semua Kegiatan").
    drawDonasiChart();

    // 2. Tambahkan event listener untuk dropdown filter KEGIATAN (hanya ada di view admin).
    const filterKegiatanSelect = document.getElementById('filter-kegiatan');
    if (filterKegiatanSelect) {
        filterKegiatanSelect.addEventListener('change', function() {
            // Ambil ID kegiatan yang dipilih.
            const selectedKegiatanId = this.value;
            // Gambar ulang chart dengan filter ID kegiatan yang baru.
            drawDonasiChart(selectedKegiatanId);
        });
    }

    // 3. Tambahkan event listener untuk filter BULAN (untuk kartu statistik).
    document.querySelectorAll('.dropdown-item[data-bulan]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const bulan = this.getAttribute('data-bulan');
            const namaBulan = this.textContent;

            // Update teks tombol dropdown bulan.
            document.getElementById('orders-month').textContent = namaBulan;
            
            // Panggil fungsi AJAX untuk update kartu statistik (bukan chart).
            filterDonasi(bulan); 
        });
    });
});

/**
 * Fungsi AJAX untuk memfilter kartu statistik (Total Donasi, Terbayar, dll).
 * @param {string} bulan Nomor bulan yang dipilih.
 */
function filterDonasi(bulan) {
    // Pastikan jQuery sudah dimuat jika menggunakan $.ajax
    $.ajax({
        url: '{{ route("donasi.filter") }}', // Memanggil route bernama 'donasi.filter'
        method: 'GET',
        data: {
            bulan: bulan,
            _token: "{{ csrf_token() }}" // Menambahkan CSRF token untuk keamanan
        },
        success: function (response) {
            // Update teks pada kartu statistik dengan data baru.
            $('#total-donasi').text('Rp' + new Intl.NumberFormat('id-ID').format(response.total_donasi || 0));
            $('#paid').text(response.jumlah_settlement || 0);
            $('#pending').text(response.jumlah_pending || 0);
            $('#expire').text(response.jumlah_expired || 0);
        },
        error: function (error) {
            console.error('Error memfilter data donasi:', error);
        }
    });
}
</script>
@endpush
