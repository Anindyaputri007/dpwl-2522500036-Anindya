<?php

class Verifikasi_pembayaran_controller extends Controller
{
    private Verifikasi_pembayaran_model $model;

    public function __construct()
    {
        require_once APPPATH . 'models/Verifikasi_pembayaran_model.php';
        require_once APPPATH . 'helpers/auth_helper.php';
        require_once APPPATH . 'helpers/flash_helper.php';

        require_admin_login();

        $this->model = new Verifikasi_pembayaran_model();
    }

    // Menampilkan daftar pembayaran yang menunggu verifikasi.
    public function index(): void
    {
        $flash = get_flash_message();
        $error = null;

        try {
            $pembayaran = $this->model->getPembayaranMenungguVerifikasi();
        } catch (Throwable $e) {
            $pembayaran = [];
            $error = 'Data pembayaran gagal ditampilkan.';
        }

        $this->view('admin/verifikasi_pembayaran_view', [
            'username' => $_SESSION['admin_username'],
            'pembayaran' => $pembayaran,
            'flash' => $flash,
            'error' => $error
        ]);
    }

    // Memproses tindakan terima atau tolak pembayaran.
    public function verifikasi(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metode tidak diizinkan.');
        }

        $kodeBayar = trim($_POST['kode_bayar'] ?? '');
        $aksi = trim($_POST['aksi'] ?? '');

        if (
            $kodeBayar === '' ||
            !in_array($aksi, ['terima', 'tolak'], true)
        ) {
            set_flash_message(
                'error',
                'Data verifikasi tidak valid.'
            );

           header('Location: ' . site_url('admin/pembayaran'));
exit;
        }

        try {
            $berhasil = $this->model->verifikasiPembayaran(
                $kodeBayar,
                $aksi
            );

            if ($berhasil) {
                $pesan = $aksi === 'terima'
                    ? 'Pembayaran berhasil diterima.'
                    : 'Pembayaran berhasil ditolak.';

                set_flash_message('success', $pesan);
            } else {
                set_flash_message(
                    'error',
                    'Pembayaran tidak dapat diverifikasi. Periksa kembali status dan bukti pembayaran.'
                );
            }
        } catch (Throwable $e) {
            set_flash_message(
                'error',
                'Terjadi kesalahan saat memproses verifikasi pembayaran.'
            );
        }

        header('Location: ' . site_url('admin/pembayaran'));
exit;
        
    }

public function bukti(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        exit('Metode tidak diizinkan.');
    }

    $kodeBayar = trim($_GET['kode_bayar'] ?? '');

    if ($kodeBayar === '') {
        http_response_code(400);
        exit('Kode pembayaran tidak valid.');
    }

    try {
        $namaFile = $this->model->getBuktiPembayaranAdmin($kodeBayar);
    } catch (Throwable $e) {
        http_response_code(500);
        exit('Bukti pembayaran gagal diakses.');
    }

    if (!$namaFile || basename($namaFile) !== $namaFile) {
        http_response_code(404);
        exit('Bukti pembayaran tidak ditemukan.');
    }

    $folder = realpath(
    dirname(APPPATH)
    . DIRECTORY_SEPARATOR . 'uploads'
    . DIRECTORY_SEPARATOR . 'bayar'
);

if ($folder === false) {
    http_response_code(404);
    exit('Folder bukti pembayaran tidak ditemukan.');
}
    $path = realpath($folder . DIRECTORY_SEPARATOR . $namaFile);

    if (
        $path === false ||
        dirname($path) !== $folder ||
        !is_file($path)
    ) {
        http_response_code(404);
        exit('File bukti pembayaran tidak ditemukan.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($path);

    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
        http_response_code(415);
        exit('Format bukti pembayaran tidak diizinkan.');
    }
if (ob_get_length() !== false && ob_get_length() > 0) {
    ob_clean();
}
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($path));
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store');

    readfile($path);
    exit;
}

}
