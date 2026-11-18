# pertemuan-09
## P9 – Tahap 1: Pemeriksaan Kesiapan Aplikasi P7

Hasil Pemeriksaan

Aplikasi P7 dapat dijalankan.
Login admin dan tenant berfungsi.
Katalog kendaraan dapat diakses.
Detail kendaraan dapat diakses.
Pengelolaan kendaraan dan foto tersedia.

### Tahap 2.1 – Menampilkan Halaman Pembayaran Penyewa


- Membuat file `Pembayaran_model.php` pada folder `application/models` untuk mengelola data pembayaran.
- Menambahkan fungsi untuk mengambil data pembayaran berdasarkan kode pembayaran atau kode sewa milik penyewa yang sedang login.
- Mengambil informasi transaksi, data penyewa, dan rincian kendaraan dari database.
- Menambahkan fungsi `simpanBuktiPembayaran()` untuk menyimpan nama file bukti pembayaran dan memperbarui waktu pembayaran pada tabel `t_bayar`.
- Membuat file `Pembayaran_controller.php` pada folder `application/controllers` untuk menangani proses pembayaran penyewa.
- Menambahkan pemeriksaan login penyewa dan metode HTTP pada proses pembayaran.
- Menambahkan proses validasi dan upload bukti pembayaran dengan format JPEG, PNG, atau WEBP serta batas ukuran maksimal 5 MB.
- Menambahkan proses penyimpanan bukti pembayaran ke folder `uploads/bayar/`.
- Memastikan status pembayaran tetap `pending` setelah bukti pembayaran berhasil diunggah.
- Menambahkan fungsi untuk mengambil data pembayaran DP terbaru berdasarkan akun penyewa.
- Menghubungkan data pembayaran dengan data transaksi dan penyewa.
- Menampilkan informasi pembayaran berdasarkan kode transaksi.
- Menyesuaikan `Pembayaran_controller.php` agar dapat menampilkan pembayaran terbaru ketika halaman `/pembayaran` dibuka tanpa parameter kode sewa.
- Memperbaiki pemanggilan model pada method `index()` agar hasil pencarian pembayaran tidak tertimpa oleh pemanggilan fungsi lainnya.
- Memastikan pembayaran hanya dapat diakses oleh penyewa yang memiliki transaksi tersebut.
- Menguji halaman pembayaran menggunakan akun penyewa `anindya`.

**Hasil Pengujian:**
- Halaman pembayaran berhasil ditampilkan.
- Data pembayaran DP berhasil ditemukan.
- Informasi transaksi dan status pembayaran `pending` berhasil ditampilkan.

- Gambar bukti transfer muncul di halaman pembayaran.
- Gambar berasal dari file di uploads/bayar/.
- Penyewa lain tidak dapat membuka bukti pembayaran milik akun anindya.
- Status pembayaran tetap pending.

## Tahap 3 – Membuat Verifikasi Pembayaran

Pada tahap ini dilakukan pembuatan fitur verifikasi pembayaran oleh admin untuk memeriksa bukti pembayaran DP yang telah diunggah oleh penyewa.

### Pengerjaan

- Membuat `Verifikasi_pembayaran_model.php` untuk mengambil data pembayaran dan memproses verifikasi.
- Membuat `Verifikasi_pembayaran_controller.php` untuk mengatur halaman dan proses verifikasi pembayaran.
- Membuat `verifikasi_pembayaran_view.php` sebagai halaman daftar pembayaran yang menunggu verifikasi.
- Menambahkan route untuk halaman verifikasi, proses verifikasi, dan melihat bukti pembayaran.
- Menambahkan fitur Lihat Bukti untuk menampilkan foto bukti transfer.
- Membuat fitur Terima dan Tolak Pembayaran.
- Mengatur perubahan status pembayaran dan status penyewaan berdasarkan tindakan admin.

### Hasil Pengujian

1. **Terima Pembayaran**
   - Status pembayaran berubah menjadi `valid`.
   - Status penyewaan berubah menjadi `disetujui`.

2. **Tolak Pembayaran**
   - Status pembayaran berubah menjadi `invalid`.
   - Status penyewaan berubah menjadi `ditolak`.

3. **Lihat Bukti Pembayaran**
   - Admin berhasil melihat foto bukti transfer yang diunggah oleh penyewa.

### Kesimpulan

Fitur verifikasi pembayaran admin berhasil dibuat dan diuji. Admin dapat melihat bukti pembayaran serta menerima atau menolak pembayaran penyewa.

