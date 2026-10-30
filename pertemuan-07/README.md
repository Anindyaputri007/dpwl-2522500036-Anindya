# pertemuan-07
# P7 — Tahap A.1: Pemeriksaan Kesiapan Aplikasi P6

Hasil Pemeriksaan

Aplikasi P6 dapat dijalankan.
Login admin dan tenant berfungsi.
Katalog kendaraan dapat diakses.
Detail kendaraan dapat diakses.
Pengelolaan kendaraan dan foto tersedia.
## P7 — Tahap B.1: Membuat Model Transaksi

### Perubahan
- Membuat file `application/models/Transaksi_model.php`.
- Membuat fondasi model untuk pengelolaan transaksi.
### Hasil Pemeriksaan
- [ ] File `Transaksi_model.php` berhasil dibuat.
- [ ] Kode model sesuai dengan modul P7.
- [ ] Tidak terdapat kesalahan sintaks PHP.
### Kesimpulan
Tahap B.1 berfokus pada pembuatan fondasi model transaksi untuk mendukung pengembangan fitur keranjang dan checkout pada tahap berikutnya.
Profil tenant dapat diakses.

## P7 — Tahap B.2: Membuat Controller Transaksi

### Perubahan
- Membuat file `application/controllers/Transaksi_controller.php`.
- Menghubungkan controller dengan `Transaksi_model`.
- Menambahkan method `tambah()` untuk menangani permintaan penambahan kendaraan ke keranjang.
- Menyiapkan pemeriksaan login penyewa dan metode HTTP POST.
- Menyiapkan penanganan pesan keberhasilan dan kesalahan.
### Hasil Pemeriksaan
- File `Transaksi_controller.php` berhasil dibuat.
- Controller terhubung dengan `Transaksi_model`.
- Kode controller sesuai dengan modul P7.
- Tidak terdapat kesalahan sintaks PHP.
 Kesimpulan
Tahap B.2 menyiapkan controller transaksi sebagai penghubung antara permintaan pengguna dan model transaksi untuk proses penambahan kendaraan ke keranjang.

## P7 — Tahap B.3: Membuat Route Transaksi

### Perubahan
- Menambahkan route `transaksi/tambah` pada `application/config/routes.php`.
- Menghubungkan route dengan `Transaksi_controller/tambah`.
- Menyiapkan jalur URL untuk proses penambahan kendaraan ke keranjang.

### Hasil Pemeriksaan
- Route `transaksi/tambah` telah ditambahkan.
- Route mengarah ke `Transaksi_controller/tambah`.
- Tidak terdapat kesalahan sintaks PHP.

### Kesimpulan
Tahap B.3 menyiapkan route transaksi agar permintaan penambahan kendaraan ke keranjang dapat diarahkan ke controller transaksi.

## P7 — Tahap C.1: Integrasi Tombol Keranjang pada Halaman Detail

### Perubahan
- Memperbarui formulir Add To Cart pada `application/views/katalog/detail.php`.
- Mengubah formulir menjadi metode POST menuju route `transaksi/tambah`.
- Menambahkan input tersembunyi `no_plat` dan `return_to`.
- Menyesuaikan tampilan tombol berdasarkan status kendaraan dan login penyewa.

### Hasil Pemeriksaan
- Informasi login dan tombol Login Penyewa serta Registrasi tampil saat belum login.
- Kendaraan tidak tersedia tidak dapat ditambahkan ke keranjang.
- Tombol Tambah ke Keranjang tampil saat penyewa sudah login.

### Kesimpulan
Tahap C.1 mengintegrasikan formulir penambahan kendaraan ke keranjang pada halaman detail kendaraan.