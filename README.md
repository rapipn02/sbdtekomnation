<table>
  <tr>
    <td><img src="https://github.com/user-attachments/assets/67b8e88a-fe88-47bb-b7b8-333f8499bc82" alt="Logo" width="60"></td>
    <td><h1 style="margin-left: 10px;">TEKOMDONATE</h1></td>
  </tr>
</table>

# TEKOMDONATION

**TEKOMDONATION** adalah sebuah platform donasi digital yang dirancang untuk memudahkan proses penggalangan dana dan penyaluran bantuan secara aman, cepat, dan transparan. Platform ini dikembangkan sebagai solusi untuk memfasilitasi kegiatan donasi dari berbagai pihak, mulai dari individu, kelas, organisasi, hingga donatur umum, dalam mendukung kegiatan sosial, pendidikan, dan kemanusiaan.

Dengan fitur visualisasi data dan riwayat transaksi yang transparan, TEKOMDONATION menjamin bahwa setiap dana yang diterima dan disalurkan dapat dipantau dengan jelas oleh publik maupun pihak pengelola.

---

## 🚀 Fitur Utama

- 💰 **Donasi Online Multimetode**  
  Mendukung berbagai metode pembayaran termasuk transfer bank, e-wallet, dan gateway pembayaran seperti Midtrans (jika digunakan di sisi backend).

- 📊 **Grafik Donasi Dinamis**  
  Menampilkan statistik donasi dari berbagai kegiatan sosial yang sedang berlangsung.

- 🏆 **Leaderboard Donatur Terbanyak**  
  Fitur klasemen untuk menampilkan siapa saja donatur yang paling banyak berkontribusi.

- 🔎 **Transparansi Penggunaan Dana**  
  Semua dana yang masuk dan keluar didokumentasikan melalui laporan pengeluaran lengkap dengan bukti transaksi (foto dan rincian).

---

## 🛠️ Stack Teknologi

| Layer       | Teknologi     |
|-------------|---------------|
| Backend     | Laravel (PHP) |
| Database    | MySQL         |
| Frontend    | Blade Template & Bootstrap |
| Auth        | Laravel Sanctum  |

---

## ⚙️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek Laravel ini secara lokal:

1. **Clone repository**
   ```bash
   git clone https://github.com/username/tekomdonation.git
   cd tekomdonation
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Setup koneksi database**
   - Buka file `.env`
   - Atur `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai konfigurasi MySQL kamu

6. **Jalankan migrasi database**
   ```bash
   php artisan migrate --seed
   ```

7. **(Opsional) Jalankan queue atau scheduler jika digunakan**
   ```bash
   php artisan queue:work
   php artisan schedule:work
   ```

---

## ▶️ Cara Menjalankan Aplikasi

Setelah semua instalasi dan konfigurasi selesai:

```bash
php artisan serve
```

Buka browser dan akses:

```
http://127.0.0.1:8000
```

---

## 🙌 Kontribusi

Kami sangat terbuka terhadap kontribusi! Jika kamu menemukan bug, ingin menambahkan fitur baru, atau melakukan perbaikan dokumentasi, silakan buka pull request atau buat issue.

---

## 📄 Lisensi

Proyek ini menggunakan lisensi **MIT** – silakan lihat file LICENSE untuk informasi lebih lanjut.

---

## 👨‍💻 Author

Proyek ini dikembangkan oleh tim SBD KELOMPOK A.  
Kontribusi dari para mahasiswa Teknik Komputer Universitas Andalas.  
Untuk pertanyaan dan kerjasama, hubungi melalui email atau sosial media resmi HIMATEKOM.
