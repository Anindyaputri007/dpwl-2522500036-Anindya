# pertemuan-05 
    
# TAHAP A
Menambahkan menu Manajemen Kendaraan pada navigasi admin agar pengguna dapat mengakses fitur pengelolaan data kendaraan tanpa mengganggu fitur yang sudah tersedia pada P4.

# TAHAP B
Pengujian:
*Memeriksa konfigurasi route kendaraan.
*Controller kendaraan belum tersedia pada tahap ini, sehingga pengujian fungsi secara penuh dilanjutkan pada Tahap C.

# TAHAP C
pengembangan fitur READ (menampilkan data kendaraan) menggunakan konsep MVC.
* membuat Mobil_model.php untuk mengambil data kendaraan dari database.
* Membuat Mobil_controller.php untuk memanggil Model dan mengirimkan data ke View.
* Membuat mobil_view.php untuk menampilkan daftar kendaraan dalam tabel.

# TAHAP D
 Perubahan
- Menambahkan model `Mobil_model.php` untuk pengelolaan data kendaraan.
- Menambahkan controller `Mobil_controller.php` untuk proses CRUD Mobil.
- Menambahkan view `mobil_view.php` untuk menampilkan data dan form kendaraan.
- Menambahkan validasi input kendaraan.
- Menambahkan fitur unggah foto kendaraan.

Pengujian
- Pengujian halaman daftar kendaraan.
- Pengujian form tambah kendaraan.
- Pengujian validasi input.
- Pengujian unggah foto.
- Pengujian penyimpanan data kendaraan ke database.

