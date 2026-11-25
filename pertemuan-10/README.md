# pertemuan-10
## tahap 1
1. Persiapan Workspace dan Artefak P9
Menggunakan hasil pengerjaan P9 sebagai dasar pengembangan P10.
Menyiapkan proyek pada direktori C:\laragon\www\dpwl-2522500036.
Memastikan aplikasi dapat diakses melalui http://localhost/dpwl-2522500036/.

## Tahap 2
## Menyesuaikan Struktur Basis Data untuk Status Transaksi Lunas
* B.1
- Membuka database `db_dpwl_anin` melalui phpMyAdmin.
- Memeriksa struktur tabel `t_sewa`, khususnya kolom `status_sewa`.
- Memeriksa nilai ENUM yang sudah tersedia.

* B.2
- Menambahkan nilai ENUM `lunas` pada kolom `status_sewa`.
- Mempertahankan seluruh nilai ENUM sebelumnya.

* B.3
- Memverifikasi perubahan melalui tab Structure.
- Memastikan perubahan hanya dilakukan pada kolom `status_sewa`.

## Tahap 3
## Mengambil Daftar Transaksi yang Memenuhi Syarat Pelunasan
* C.1
- Menambahkan method getDaftarPelunasan() pada application/models/Pembayaran_model.php.

* C.2
- Mengambil Detail Transaksi dan Riwayat Pembayaran
- Menambahkan method getDetailPelunasan(string $kodeSewa) pada application/models/Pembayaran_model.php.

* C.3
- Membuat Kode Pembayaran Pelunasan
- Menambahkan method internal buatKodeBayarPelunasan(string $tanggalKode) pada application/models/Pembayaran_model.php.

* C.4
- Menghitung Sisa Kewajiban dan Memvalidasi Pelunasan
- Menambahkan method simpanPelunasan() pada application/models/Pembayaran_model.php.

# Tahap 4
## Implementasi Controller Pelunasan
* D.1
- Menambahkan method pelunasanIndex() pada Pembayaran_controller.php.

* D.2
- Menambahkan method pelunasanDetail() pada Pembayaran_controller.php.

* D.3
- Menambahkan method prosesPelunasan() pada Pembayaran_controller.php.

* D.4
- Menambahkan method dokumenTransaksi() pada Pembayaran_controller.php.

# Tahap 5
## Membuat Route dan Integrasi Menu Pelunasan
* E.1
- Menambahkan route daftar pelunasan, detail pelunasan, proses pelunasan, dan dokumen transaksi pada application/config/routes.php.

* E.2
Menambahkan menu Pelunasan Transaksi pada sidebar admin di application/views/templates/sidebar.php.

# Tahap 6
## Membuat View Daftar dan Detail Pelunasan

* F.1
- Membuat View `application/views/admin/pelunasan.php`.

* F.2
- Membuat View `application/views/admin/pelunasan_detail.php`.

# Tahap 7
## Membuat Dokumen Transaksi

* G.1
- Membuat View `application/views/admin/dokumen_transaksi.php`.
- Menampilkan informasi transaksi dan status penyewaan.

* G.2
- Menguji tampilan dokumen transaksi.

