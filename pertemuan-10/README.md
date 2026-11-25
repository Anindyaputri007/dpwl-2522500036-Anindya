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
