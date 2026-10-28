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


# tahap f
F.1 Membuat Route Profil dan Persyaratan Autentikasi.
F.2 Mengintegrasikan application/controllers/Penyewa_controller.php.
F.3 Memperbarui Profil melalui application/models/Penyewa_model.php.
F.4 Membuat View Profil pada application/views/penyewa/profil.php.
F.5 Menguji Pembaruan Profil dan Penanganan Input Tidak Valid.

- Halaman profil hanya dapat diakses oleh penyewa yang sudah login.

- Data profil penyewa dapat ditampilkan dan diperbarui.

-Input yang tidak valid ditolak oleh sistem.

- Perubahan data profil tersimpan di database.

# tahap g
Hasil Pengujian Tahap G – Menghilangkan index.php dari URL Aplikasi

File .htaccess: Sudah dibuat dan dikonfigurasi untuk mengarahkan URL ke index.php.
File index.php: Pengambilan URI telah disesuaikan menggunakan parameter route.
File config.php: base_url disesuaikan dengan nama folder aplikasi dan index_page dikosongkan.
File url_helper.php: Fungsi site_url() telah disesuaikan agar URL tidak menampilkan index.php.
File routes.php: Rute default diperiksa sesuai konfigurasi aplikasi.
Pengujian URL: Perlu dipastikan halaman utama dan navigasi dapat diakses tanpa index.php.

Kesimpulan: Pengujian akhir dilakukan dengan membuka aplikasi dan memeriksa URL serta fungsi navigasinya.

Penghilangan index.php dari URL aplikasi dilakukan melalui konfigurasi .htaccess, index.php, config.php, url_helper.php, dan routes.php. Perubahan ini bertujuan agar URL aplikasi lebih sederhana dan mudah dibaca. Keberhasilan penerapan ditentukan melalui pengujian akses halaman utama dan navigasi aplikasi tanpa index.php.