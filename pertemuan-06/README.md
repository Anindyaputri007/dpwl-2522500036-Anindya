# pertemuan-06
# tahap A
1. Tujuan Pemeriksaan

Pemeriksaan ini dilakukan untuk memastikan ketersediaan aset template Zay Shop dan struktur berkas yang diperlukan untuk integrasi ke dalam proyek DPWL berbasis PHP MVC.

Pemeriksaan ini hanya mencakup ketersediaan berkas dan kesiapan awal integrasi. Pemeriksaan ini belum membuktikan bahwa tampilan, navigasi, maupun pemuatan aset telah berhasil melalui aplikasi MVC.

2. Berkas/folder yang telah diperiksa:

Folder assets/ proyek P5.
Folder aset Zay Shop: assets/zay/css/, assets/zay/img/, assets/zay/js/, dan assets/zay/webfonts/.
application/views/templates/header.php.
application/views/templates/footer.php.
application/views/templates/sidebar.php.
application/views/home/index.php.

# tahap B
### Hasil Pengujian Tahap B – Katalog Kendaraan

- **Model:** Method `getKatalog()` telah ditambahkan pada `Mobil_model.php`.
- **Controller:** Berkas `Katalog_controller.php` telah dibuat.
- **Route:** Route `katalog` telah ditambahkan pada `routes.php`.
- **View:** Berkas `header.php`, `navbar.php`, `footer.php`, dan `index.php` telah disiapkan pada folder `application/views/katalog/`.
- **URL pengujian:** `http://localhost/dpwl-2522500036/index.php/katalog`
- **Hasil pengujian:** [Halaman katalog dapat diakses melalui URL http://localhost/dpwl-2522500036/index.php/katalog, data mobil tampil sesuai data dari model, dan halaman menggunakan komponen tampilan katalog.].

# tahap c
### Hasil Pengujian Tahap C – Detail Kendaraan

- **Route:** Route `katalog/detail/(:any)` telah ditambahkan pada `routes.php`.
- **Controller:** Method `detail()` telah ditambahkan pada `Katalog_controller.php`.
- **Model:** Method `findByNoPlat()` digunakan untuk mengambil data kendaraan berdasarkan nomor plat.
- **View:** Berkas `detail.php` telah disiapkan pada folder `application/views/katalog/`.
- **URL pengujian:** `http://localhost/dpwl-2522500036/index.php/katalog/detail/[nomor-plat]`
- **Hasil pengujian:** [Halaman detail kendaraan dapat diakses melalui katalog. Informasi kendaraan ditampilkan sesuai data yang dipilih, dan route detail berhasil menghubungkan Controller, Model, dan View.].

# tahap d
### Hasil Pengujian Tahap D – Registrasi Akun Penyewa

- **Route:** Route `auth/register` telah ditambahkan pada `routes.php`.
- **Model:** Berkas `Penyewa_model.php` telah dibuat untuk memeriksa username dan menyimpan data penyewa.
- **Controller:** Proses registrasi telah ditambahkan pada `Auth.php`.
- **View:** Berkas `register.php` telah disiapkan pada folder `application/views/auth/`.
- **URL pengujian:** `http://localhost/dpwl-2522500036/index.php/auth/register`
- **Hasil pengujian:** [Formulir registrasi dapat diakses, data penyewa yang valid dapat disimpan ke database, input yang tidak valid ditolak, dan username yang sudah terdaftar tidak dapat digunakan kembali.].

# tahap e

E.1 Membuat Route Login dan Logout Penyewa.
E.2 Menambahkan Proses Login dan Logout pada application/controllers/Auth.php.
E.3 Membuat View Login pada application/views/auth/login_penyewa.php.
E.4 Menguji Login Berhasil, Login Gagal, Sesi, Logout, dan Pembatasan Akses.

- Halaman login penyewa dapat diakses.

- Data login yang valid dapat digunakan untuk masuk.

- Login dengan data yang tidak valid ditolak.

- Penyewa dapat logout dan mengakhiri sesi login.
