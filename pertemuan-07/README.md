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

## P7 — Tahap C.2: Mengintegrasikan Tombol Keranjang pada Halaman Katalog

### Perubahan
- Memperbarui tombol keranjang pada `application/views/katalog/index.php`.
- Tombol **Tambah ke Keranjang** aktif jika penyewa sudah login dan kendaraan tersedia.
- Tombol **Tambah ke Keranjang** nonaktif jika penyewa belum login.
- Tombol **Tidak Dapat Disewa** ditampilkan jika kendaraan tidak tersedia.
- Form penambahan kendaraan menggunakan metode `POST` dan mengarah ke `transaksi/tambah`.

### Hasil Pengujian
- Halaman katalog dapat dibuka.
- Tombol keranjang nonaktif saat penyewa belum login.
- Tombol keranjang aktif saat penyewa login dan kendaraan tersedia.
- Kendaraan yang tidak tersedia tidak dapat ditambahkan ke keranjang.

### Kesimpulan
Tahap C.2 dilakukan untuk menyesuaikan tombol keranjang pada halaman katalog berdasarkan status login penyewa dan ketersediaan kendaraan.

## P7 — Tahap D.1: Menambahkan Pesan dan Tautan Keranjang pada Navbar

### Perubahan
- Memperbarui `application/views/katalog/navbar.php`.
- Menampilkan menu registrasi dan login ketika penyewa belum login.
- Menampilkan menu logout, profil, dan ikon keranjang ketika penyewa sudah login.
- Menambahkan tampilan pesan flash pada navbar.
- Mempertahankan modal pencarian.
- Menghapus jumlah keranjang statis karena belum terhubung dengan data transaksi.

### Hasil Pengujian
- Navbar tampil pada halaman katalog.
- Menu login dan registrasi tampil ketika penyewa belum login.
- Menu logout dan profil tampil ketika penyewa sudah login.
- Pesan flash tampil ketika tersedia.
- Ikon keranjang dan modal pencarian diperiksa.

### Kesimpulan
Tahap D.1 dilakukan untuk menyesuaikan navbar dengan status login penyewa serta menyiapkan tampilan pesan dan akses keranjang. Pengujian dilakukan untuk memastikan setiap elemen berfungsi sesuai implementasi.