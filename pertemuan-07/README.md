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

## P7 — Tahap D.2: Mengirim Jumlah Keranjang ke Halaman Katalog dan Detail

### Perubahan
- Menambahkan method `getJumlahMobilKeranjang()` pada `Transaksi_model.php`.
- Menghitung jumlah kendaraan dalam keranjang berdasarkan akun penyewa yang sedang login.
- Mengambil data jumlah keranjang untuk ditampilkan pada navbar.
- Jumlah keranjang menyesuaikan akun penyewa.
- Keranjang kosong menampilkan jumlah `0`.

### Hasil Pengujian
- Jumlah keranjang tampil pada navbar.
- Jumlah keranjang sesuai dengan data milik akun penyewa.
- Jumlah keranjang tetap `0` jika belum ada kendaraan yang ditambahkan.
- Jumlah keranjang tampil pada halaman katalog dan detail kendaraan.

### Kesimpulan
Tahap D.2 bertujuan menampilkan jumlah kendaraan dalam keranjang berdasarkan akun penyewa yang sedang login.

## P7 — Tahap D.3: Mengirim Jumlah Keranjang ke Halaman Profil Penyewa
### Hasil Pengujian
-  Jumlah keranjang tampil pada navbar.
-  Jumlah keranjang sesuai dengan data milik akun penyewa.
-  Jumlah keranjang bertambah setelah kendaraan ditambahkan.
-  Jumlah keranjang tampil pada halaman katalog dan detail kendaraan.

### Kesimpulan
Tahap D.3 berhasil. Jumlah kendaraan dalam keranjang berhasil ditampilkan pada navbar dan menyesuaikan data akun penyewa yang sedang login.


## P7 — Tahap E.1: Mengintegrasikan Proses Penambahan Kendaraan ke Keranjang

### Perubahan
- Melengkapi method pada `Transaksi_model.php` untuk proses penambahan kendaraan ke keranjang.
- Memeriksa ketersediaan kendaraan sebelum ditambahkan.
- Membuat kode transaksi untuk keranjang penyewa.
- Menyimpan data transaksi ke tabel `t_sewa`.
- Menyimpan kendaraan yang dipilih ke tabel `t_pilih`.
- Mencegah kendaraan yang sama ditambahkan dua kali dalam keranjang.
- Menampilkan pesan notifikasi setelah proses penambahan kendaraan.

### Hasil Pengujian
-  Kendaraan berhasil ditambahkan ke tabel `t_pilih`.
-  Data transaksi berhasil tersimpan pada tabel `t_sewa`.
-  Beberapa kendaraan menggunakan kode transaksi yang sama.
-  Kendaraan yang sudah ada dalam keranjang tidak dapat ditambahkan kembali.
-  Jumlah kendaraan pada ikon keranjang tampil sesuai data.
-  Pesan notifikasi setelah penambahan kendaraan berhasil ditampilkan.

### Kesimpulan
Tahap E.1 berhasil. Proses penambahan kendaraan ke keranjang, penyimpanan data transaksi, dan penampilan pesan notifikasi telah berhasil diuji.


## P7 — Tahap F.1: Membuat Halaman Isi Keranjang

### Perubahan
- Membuat berkas `application/views/transaksi/keranjang.php`.
- Menyiapkan halaman khusus untuk menampilkan isi keranjang penyewa.
### Kesimpulan
Berkas halaman isi keranjang telah dibuat pada tahap F.1. Pengujian tampilan dan fungsi halaman akan dilakukan setelah integrasi dengan controller dan model pada tahap berikutnya.


## P7 — Tahap F.2: Menambahkan Method Keranjang dan Lainnya pada Controller Transaksi

### Perubahan
- Menambahkan method `keranjang()` pada `Transaksi_controller.php`.
- Menambahkan method `perbaruiPeriode()` untuk memperbarui periode penyewaan.
- Menambahkan method `hapus()` untuk menghapus kendaraan dari keranjang.
- Menambahkan method `checkout()` untuk menampilkan konfirmasi dan memproses checkout.
- Mengintegrasikan method Controller dengan method pada `Transaksi_model.php`.
- Menambahkan route `transaksi/keranjang`.
- Menambahkan route `transaksi/perbarui-periode`.
- Menambahkan route `transaksi/hapus`.
- Menambahkan route `transaksi/hapus/(:any)`.
- Menambahkan route `transaksi/checkout`.
- Menghubungkan ikon keranjang pada navbar ke halaman keranjang.

### Hasil Pengujian
- Penyewa yang memiliki keranjang aktif dapat membuka halaman keranjang.
- Data keranjang ditampilkan sesuai dengan akun penyewa yang login.
- Penyewa tanpa keranjang aktif diarahkan kembali ke katalog dengan pesan bahwa keranjang masih kosong.
- Jumlah kendaraan pada ikon keranjang sesuai dengan isi keranjang.
- Periode penyewaan dapat diperbarui.
- Kendaraan dapat dihapus dari keranjang.

### Kesimpulan
Tahap F.2 berfokus pada integrasi halaman keranjang dengan Controller, Model, dan route transaksi. Pengujian dilakukan untuk memastikan pengelolaan keranjang dan proses menuju checkout berjalan sesuai dengan ketentuan modul.
