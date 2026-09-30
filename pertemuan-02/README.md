# pertemuan-02
Nama     : ANINDYA PUTRI MAHENDRA
Nim      : 2522500036
Kelompok : SI3A

## 1. Tujuan Praktikum 
 Praktikum ini bertujuan untuk memahami arsitektur dasar Model-View-Controller (MVC) dan mekanisme (Front Controller) dalam mengarahkan (routing) URL ke Controller, Method, serta Parameter secara mandiri. Selain itu, mahasiswa dilatih untuk melakukan (debugging) sintaks PHP via CLI (php -l), menguji penanganan error 404/500, menerapkan metode ATM (Amati-Tiru-Modifikasi) dengan menambah route dan Controller kustom, serta mengelola dokumentasi dan version control proyek menggunakan Git (add, commit , push) ke repositori lokal.
 
## 2. Struktur Direktori 
pertemuan-02/
├── application/
│   ├── config/                 # Buat nyimpen file konfigurasi (config.php & routes.php)
│   │   ├── config.php
│   │   └── routes.php
│   ├── controllers/            # Isi controller aplikasi (Home.php)
│   │   └── Home.php
│   ├── helpers/                # Fungsi bantuan kayak url_helper.php (base_url & site_url)
│   │   └── url_helper.php
│   └── views/                  # Tampilan HTML/PHP yang bakal muncul di browser
│       └── home/
│           ├── index.php
│           └── info.php
├── assets/                     # Berkas statis publik, contohnya CSS (app.css)
│   └── css/
│       └── app.css
├── system/                     # Inti sistem buatan (Controller.php & Router.php)
│   └── core/
│       ├── Controller.php     
│       └── Router.php
├── dokumentasi/                # Tempat nyimpen screenshot bukti pengujian
├── index.php                   # Front controller / pintu masuk utama semua request
└── README.md                   # File laporan praktikum
 
## 3. Front controller 
Pada proyek P2 ini, file index.php berfungsi sebagai Front Controller atau pintu masuk utama (single entry point) untuk aplikasi.   Gampangnya, pas kita buka link atau halaman dinamis di browser, kita gak langsung ngakses file controller/view secara terpisah. Semuanya wajib lewat index.php dulu.
Di dalam index.php ini, aplikasi melakukan beberapa hal:   Nentuin path atau lokasi folder sistem (APPPATH, SYSPATH, dll). Manggil/load file-file penting kayak config.php, url_helper.php, Controller.php, sama routes.php.Baca URL yang kita ketik di browser, terus ngoper (dispatch) URL itu ke Router.php buat dicari controller sama method mana yang bakal dieksekusi.   
 
## 4. Routing dan Pemetaan URL 
| URL/Route | Controller | Method | Parameter | View | 
|---|---|---|---|---| 
| / | Home | index | - | home/index.php | 
| home/index | Home | index | - | home/index.php | 
| home/info/mvc | Home | info | mvc | home/info.php | 
| info/routing | Home | info | routing | home/info.php | |mahasiswa/detail/2522500036| |
|Mahasiswa | detail |2522500050 |produk/detail.php
 
Penjelasan:-URL / Route (materi/detail/p2)Segmen alamat URL yang diakses oleh pengguna pada browser (misalnya: http://localhost/dpwl-NIM/materi/detail/p2).  
- Controller (Materi)Router membaca segmen pertama (materi) dan mengarahkannya ke kelas controller Materi.php (application/controllers/Materi.php).  
  -Method (detail)Router membaca segmen kedua (detail) dan mengeksekusi method/fungsi detail() yang berada di dalam controller Materi.  
   -Parameter (p2)Router menangkap segmen ketiga (p2) sebagai argumen/parameter nilai yang dikirimkan ke dalam method detail($id) untuk menentukan materi spesifik yang ingin diproses/ditampilkan.   
   -View (materi/detail.php)Method detail() pada controller mengolah parameter p2 tersebut, lalu memuat dan menyuntikkan datanya ke berkas tampilan detail.php yang berada di dalam folder application/views/materi/ untuk disajikan ke browser pengguna. 
 
Tambahkan satu baris untuk route hasil Tahap Modifikasi ATM yang dibuat berdasarkan objek atau konteks 
aplikasi DPW, kemudian jelaskan pemetaan route → Controller → method → parameter → View. 
 
## 5. Base URL dan Helper 
Jelaskan fungsi base_url() dan site_url(), kemudian berikan contoh penggunaannya pada implementasi P2:  - base_url() untuk memanggil assets/css/app.css;  - site_url() untuk membentuk URL navigasi/route aplikasi. 

    base_url() dan site_url() adalah fungsi bantuan (helper) di url_helper.php biar kita gak usah nulis alamat URL manual/hardcoded.
Fungsi Singkat:
    base_url(): Mengambil URL utama folder proyek (tanpa index.php). Dipakai buat manggil file statis kayak CSS, JS, atau foto.
    site_url(): Mengambil URL proyek yang otomatis nempel index.php di depannya. Dipakai khusus buat bikin link pindah halaman atau route.
 Contoh Penggunaan di P2:
Manggil file CSS (base_url): <link rel="stylesheet" href="<?= htmlspecialchars(base_url('assets/css/app.css'), ENT_QUOTES, 'UTF-8') ?>">
Bikin link navigasi (site_url):<a href="<?= htmlspecialchars(site_url('info/routing'), ENT_QUOTES, 'UTF-8') ?>">Halaman Info</a>

## 6. Alur Request-response 
Jelaskan dua alur berikut: 
 
1. Alur eksekusi aktual P2: 
Browser → index.php → Router → Controller → View → Response. 
    Browser: Pengguna mengetik alamat URL (contoh: http://localhost/dpwl-nim/index.php/info/routing).
    index.php: Menerima request sebagai Front Controller, memuat file konfigurasi (config.php), helper, dan core sistem.
    Router: Membaca URI /info/routing lalu mencocokkannya dengan aturan route untuk menentukan Controller dan Method yang dipanggil (Controller Home, Method info()).
    Controller: Menjalankan logika program, menyiapkan data yang akan dikirim, lalu memanggil file View.
    View: Menggabungkan struktur HTML dengan data dari Controller (serta memanggil helper seperti base_url()).
    Response: Hasil akhir berupa halaman HTML dikirim kembali ke Browser untuk ditampilkan ke pengguna. 
2. Posisi Model dalam arsitektur MVC lengkap: 
Browser → index.php → Router → Controller → Model → basis data/data → Model → Controller → View → 
Response. 
    Peran Model: Model bertugas khusus mengolah data dan melakukan kueri ke basis data (CRUD).
    Alur Kerjanya: Controller meminta data ke Model $\rightarrow$ Model mengambil/mengolah data dari Database $\rightarrow$ Model mengembalikan hasilnya ke Controller $\rightarrow$ Controller melempar data tersebut ke View untuk ditampilkan.   
 
Pada implementasi P2, Model belum digunakan karena akses dan pengelolaan basis data mulai 
diimplementasikan pada P3. 
 
## 7. Hasil Pengujian dan Debugging 
Catat skenario pengujian valid dan tidak valid beserta hasilnya. Jika ditemukan kesalahan selama 
implementasi, dokumentasikan sekurang-kurangnya satu proses debugging yang memuat: 

Gejala → Penyebab → Perbaikan → Hasil Uji Ulang 

    Seluruh berkas PHP telah diperiksa melalui Terminal VS Code dengan perintah (php -l) dan menghasilkan status *"No syntax errors detected"*, serta seluruh pengujian peramban untuk skenario valid (halaman utama, pemetaan langsung, parameter, *custom route*, dan modifikasi ATM) maupun skenario tidak valid (uji *error* HTTP 404/500) berhasil berjalan sesuai harapan. Adapun satu kendala *debugging* yang sempat ditemukan yaitu tampilan CSS halaman utama tidak muncul (**Gejala**), yang disebabkan oleh *typo* penulisan nama folder aset pada fungsi base_url() di berkas View ( asset kurang huruf `s`) (**Penyebab**); masalah ini diselesaikan dengan mengoreksi jalurnya menjadi base_url('assets/css/app.css') (**Perbaikan**), sehingga setelah halaman di-*refresh*, gaya tampilan CSS berhasil dimuat kembali dengan sempurna (**Hasil Uji Ulang**).

Jika seluruh implementasi langsung berjalan sesuai hasil yang diharapkan, jelaskan hasil pemeriksaan 
sintaks dan pengujian yang telah dilakukan. 
 
## 8. Bukti Tangkapan Layar 
Sisipkan gambar yang relevan dari folder dokumentasi/ dengan perintah: 
 
### Gambar 1. Hasil Pengujian Halaman Utama  
![Gambar 1 - Halaman Utama](dokumentasi/gambarpertama.jpg)  
 
### Gambar 2. Hasil Pengujian Custom Route  
![Gambar 2 - Custom Route](dokumentasi/gambarkedua.jpg) 
 
## 9. Kesimpulan P2 
Jelaskan apa yang sudah dapat dilakukan kerangka MVC dan apa yang baru akan ditambahkan pada P3.
    Pada praktikum Pertemuan 2 (P2) ini, kerangka kerja MVC dasar yang dibangun sudah berhasil menangani alur Front Controller (index.php), pemetaan routing dinamis via Router.php, penanganan Controller beserta pengiriman parameter ke View, pembuatan rute kustom (termasuk modifikasi ATM), serta penyediaan fungsi helper (base_url() dan site_url()) untuk manajemen berkas statis dan navigasi. Arsitektur ini baru berfokus pada alur Request-Response antara Router, Controller, dan View tanpa adanya pengelolaan data kompleks. Selanjutnya pada Pertemuan 3 (P3), kerangka kerja ini akan dilengkapi dengan komponen Model untuk menghubungkan aplikasi ke basis data (Database) serta menangani operasi pengolahan data (CRUD).  