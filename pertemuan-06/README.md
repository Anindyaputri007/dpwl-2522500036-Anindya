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