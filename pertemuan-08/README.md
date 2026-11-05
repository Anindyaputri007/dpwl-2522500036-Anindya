# pertemuan-08
### UTS – Persiapan Project

# Tahap A
Menyalin folder project awal sebagai bahan dasar untuk pengembangan sistem pada tahap Ujian Tengah Semester (UTS).

### UTS – Penambahan Manajemen Penyewa

# Tahap B
Menambahkan file `manajemen_penyewa_model.php` sebagai bagian dari implementasi fitur Manajemen Data Penyewa pada sisi Admin. Fitur ini bertujuan untuk mengelola data penyewa menggunakan pola MVC (Model, View, Controller) dengan menerapkan fungsi CRUD (Create, Read, Update, Delete).

# Tahap C

- Menambahkan menu **Manajemen Penyewa** pada file `sidebar.php`.
- Menu ditambahkan setelah menu Manajemen Kendaraan.


# Tahap D 
## Controller Manajemen Penyewa

- Membuat file `application/controllers/Manajemen_penyewa_controller.php`.
- Memanggil `Manajemen_penyewa_model.php` pada constructor.

### 5. Tambah Penyewa

- Menambahkan fungsi `tambah()` pada `Manajemen_penyewa_controller.php`.
- Menambahkan validasi untuk memastikan data wajib telah diisi.
- Menggunakan `password_hash()` untuk mengamankan password penyewa.
- Menambahkan proses penyimpanan data melalui fungsi `create()` pada `Manajemen_penyewa_model.php`.
- Membuat file view `manajemen_penyewa_form.php` sebagai form tambah penyewa.
- Menambahkan input username, password, NIK, nama lengkap, nomor HP, dan alamat lengkap.
- Menambahkan tombol Simpan dan Kembali pada form.
- Menambahkan route `admin/penyewa/tambah` pada `routes.php`.
- Menambahkan pesan flash untuk proses penyimpanan data.