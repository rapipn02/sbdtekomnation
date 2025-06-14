"use strict"; // Jika Anda menggunakan 'use strict', pastikan itu di baris paling atas file.

$(document).ready(function () {
    // Inisialisasi DataTable secara kondisional
    if ($("#table-1").length) { // Cek jika elemen ada
        $("#table-1").DataTable();
    }
});

function submitDel(id) {
    $("#del-" + id).submit();
}

// Event handler untuk tombol donasi
$('#tombol-form-donasi').on('click', function () {
    // ... (kode pengiriman donasi Anda yang sudah ada, sepertinya sudah OK) ...
    // Pastikan input id_daftar_donasi memiliki value yang benar
    const idDaftar = $('input#id_daftar_donasi').val();
    const jumlahDonasi = $('input#jumlah_donasi').val();

    // Validasi sederhana sebelum kirim
    if (!jumlahDonasi || parseFloat(jumlahDonasi) <= 0) {
        alert('Masukkan jumlah donasi yang valid.');
        return;
    }

    // Nonaktifkan tombol untuk mencegah klik ganda
    $(this).prop('disabled', true).text('Memproses...');
    var self = this; // Simpan referensi ke tombol

    $.post("/user-donasi/kirim-donasi", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id_daftar_donasi: idDaftar,
        jumlah_donasi: jumlahDonasi,
    },
    function (response) {
        $(self).prop('disabled', false).text('Kirim'); // Aktifkan tombol kembali
        $('#exampleModal').modal('hide'); // Tutup modal jika ada

        if (response && response.snapToken) {
            snap.pay(response.snapToken, {
                onSuccess: function (result) {
                    sendResponse(result, response.idDonasi, response.snapToken);
                },
                onPending: function (result) {
                    sendResponse(result, response.idDonasi, response.snapToken);
                },
                onError: function (result) {
                    // Mungkin tidak mengirim respons jika error dari Midtrans,
                    // tapi bisa tampilkan pesan error langsung
                    console.error('Midtrans payment error:', result);
                    alert('Terjadi kesalahan pada pembayaran Midtrans: ' + (result.status_message || 'Silakan coba lagi.'));
                },
                onClose: function () {
                    console.log('Popup Midtrans ditutup oleh pengguna.');
                    // Tidak perlu sendResponse jika hanya ditutup
                }
            });
        } else {
            alert('Gagal memproses permintaan donasi. Token tidak diterima.');
            console.error('Invalid response from /user-donasi/kirim-donasi:', response);
        }
        // return false; // Tidak perlu 'return false' di sini untuk $.post callback
    }).fail(function(xhr, status, error) {
        $(self).prop('disabled', false).text('Kirim'); // Aktifkan tombol kembali
        alert('Error mengirim permintaan donasi: ' + xhr.status + ' ' + error);
        console.error('AJAX error for /user-donasi/kirim-donasi:', xhr.responseText);
    });
});


function sendResponse(response, idDonasi, snapToken) {
    $.post("/user-donasi/notification", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        response: response,
        idDonasi: idDonasi,
        snapToken: snapToken
    },
    function (kode_donasi_response) {
        // Asumsikan controller mengembalikan string kode donasi langsung, atau objek dengan property kode_donasi
        var kode_donasi_final = '';
        if(typeof kode_donasi_response === 'object' && kode_donasi_response !== null && kode_donasi_response.kode_donasi){
            kode_donasi_final = kode_donasi_response.kode_donasi;
        } else if (typeof kode_donasi_response === 'string'){
            kode_donasi_final = kode_donasi_response;
        }

        if(kode_donasi_final) {
            window.location.href = "/riwayat/invoice/" + kode_donasi_final;
        } else {
            alert('Transaksi berhasil/pending, namun gagal redirect ke invoice.');
            console.log("Invalid kode_donasi response from notification:", kode_donasi_response);
            // window.location.href = "/riwayat/invoice"; // Fallback redirect
        }
    }).fail(function(xhr, status, error) {
        alert('Error mengirim notifikasi pembayaran: ' + xhr.status + ' ' + error);
        console.error('AJAX error for /user-donasi/notification:', xhr.responseText);
        // window.location.href = "/riwayat/invoice"; // Fallback redirect
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // --- PERBAIKAN UNTUK CHART ---
    // Cek apakah elemen canvas #donasiChart ada di halaman ini
    var donasiChartCanvas = document.getElementById('donasiChart');
    if (donasiChartCanvas) {
        // Hanya lakukan AJAX call jika canvas ada
     /*
        $.ajax({
            url: '/donasi-chart',
            method: 'GET',
            dataType: 'json',
            success: function (chartData) {
                // Pastikan elemen masih ada sebelum merender (jaga-jaga jika DOM berubah)
                if (document.getElementById('donasiChart')) {
                    renderChart(chartData);
                }
            },
            error: function (error) {
                console.error('Error retrieving chart data:', error);
            }
        });
        */
    } else {
        console.log("Canvas #donasiChart tidak ditemukan di halaman ini. Chart tidak dimuat.");
    }
    // --- AKHIR PERBAIKAN UNTUK CHART ---
});


function renderChart(chartData) {
    var canvasElement = document.getElementById('donasiChart');
    // Pengecekan tambahan di dalam fungsi renderChart (best practice)
    if (!canvasElement) {
        console.error("Fungsi renderChart dipanggil, tapi canvas #donasiChart tidak ditemukan.");
        return;
    }

    const labels = chartData[Object.keys(chartData)[0]] ? chartData[Object.keys(chartData)[0]]['labels'] : [];
    const datasets = Object.keys(chartData).map((key) => {
        return {
            label: key,
            data: chartData[key]['data'],
            borderColor: getRandomColor(), // Gunakan getRandomColor atau tentukan warna spesifik
            backgroundColor: getRandomColor() + '50', // Contoh dengan transparansi
            fill: false // atau true jika ingin area chart diwarnai
        };
    });

    const data = {
        labels: labels,
        datasets: datasets
    };

    const config = {
        type: 'bar', // atau 'line', dll.
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Grafik Donasi per Kategori'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Kategori Donasi' // Sesuaikan label sumbu X
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Donasi'
                    },
                    beginAtZero: true // Mulai sumbu Y dari 0
                }
            }
        },
    };

    // Hapus chart lama jika ada untuk mencegah tumpukan chart saat update
    let existingChart = Chart.getChart(canvasElement);
    if (existingChart) {
        existingChart.destroy();
    }

    new Chart(canvasElement, config); // Buat chart baru
}


function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$(document).ready(function () {
    $('.dropdown-item[data-bulan]').on('click', function () { // Lebih spesifik selectornya
        $('.dropdown-item[data-bulan]').removeClass('active');
        $(this).addClass('active');
        var bulan = $(this).data('bulan');
        var namaBulan = $(this).text();
        $('#orders-month').text(namaBulan);

        // Cek apakah elemen untuk filter ada sebelum memanggil AJAX
        if ($('#total-donasi').length && $('#paid').length && $('#pending').length && $('#expire').length) {
            filterDonasi(bulan);
        } else {
            console.log("Elemen untuk filter donasi tidak ditemukan di halaman ini.");
        }
    });
});

function filterDonasi(bulan) {
    $.ajax({
        url: '/filter-donasi',
        method: 'GET',
        data: {
            bulan: bulan
        },
        success: function (response) {
            // Pastikan untuk memformat angka jika perlu (misal dengan toLocaleString)
            $('#total-donasi').text('Rp' + (response.total_donasi ? parseFloat(response.total_donasi).toLocaleString('id-ID') : '0'));
            $('#paid').text(response.jumlah_settlement || '0');
            $('#pending').text(response.jumlah_pending || '0');
            $('#expire').text(response.jumlah_expired || '0');
        },
        error: function (error) {
            console.error('Error memfilter donasi:', error);
        }
    });
}