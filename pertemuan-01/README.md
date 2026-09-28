# pertemuan-01
1. kesinambungan PWD–DPW–DPWL;
Jawaban :PWD,DPW, dan DPWL merupakan mata kulaih yang saling berhubungan.PWD mempelajari dasar-dasar pemrograman web,kemudian di DPW dasar tersebut  digunakan untuk membuat aplikasi web.
Setelah itu, DPWL mempelajari pengembangan aplikasi yang lebih lanjut, salah satunya dengan menngunakan konsep MVC.
2. perbedaan PHP terstruktur dan MVC;
Jawaban: PHP terstruktur biasanya memiliki kode yang masih sederhana dan prosesnya dapat ditulis dalam satu bagian. Sedangkan MVC membagi kode menjadi Model,View,dan Controller, sehingga kode rapi dan lebih mudah dikelola.
3. fungsi Model, View, dan Controller;
Jawaban: @Model berfungsi untuk mengatur data dan database
@View berfungsi untuk menampilkan tampilan aplikasi kepada user.
@Controller berfungsi untuk mengatur proses dan menghubungkan Model dengan view
4. alur request–response MVC;
Jawaban:User → Controller → Model → Controller → View → User
User melakukan request, kemudian Controller memproses request tersebut. Jika membutuhkan data, Controller akan mengambilnya melalui Model. Setelah data didapatkan, Controller mengirimkannya ke View untuk ditampilkan kepada user.
5. pemetaan satu atau beberapa bagian/fitur aplikasi DPW ke Model, Controller, dan View disertai alasan; dan
Jawaban:Contohnya pada aplikasi Sistem Informasi Akademik:
Data Mahasiswa
Model: mengatur data mahasiswa.
Controller: memproses data mahasiswa.
View: menampilkan data mahasiswa.
Data Mata Kuliah
Model: mengatur data mata kuliah.
Controller: memproses data mata kuliah.
View: menampilkan data mata kuliah.
Data Jadwal
Model: mengatur data jadwal.
Controller: memproses data jadwal.
View: menampilkan data jadwal.
Pembagian ini dilakukan supaya setiap bagian kode memiliki fungsi masing-masing dan tidak tercampur.
6. kesimpulan P1.
Dari pembahasan ini dapat disimpulkan bahwa MVC membuat struktur aplikasi menjadi lebih rapi dan terorganisir. Model digunakan untuk data, View untuk tampilan, dan Controller untuk mengatur proses. Dengan menggunakan MVC, aplikasi juga akan lebih mudah untuk dikembangkan dan diperbaiki.