<?php

require_once APPPATH . 'models/Pembayaran_model.php';

class Pembayaran_controller extends Controller
{
    private Pembayaran_model $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new Pembayaran_model();
    }

    /**
     * Menampilkan halaman pembayaran berdasarkan kode transaksi.
     */
    
public function index(): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('GET');

    try {
        $pembayaran = $this->pembayaranModel
            ->getDaftarPembayaranPenyewa($userPlg);

        $flash = $_SESSION['flash_pembayaran'] ?? null;
        unset($_SESSION['flash_pembayaran']);

        $this->view('pembayaran/index', [
            'pembayaran' => $pembayaran,
            'flash' => $flash
        ]);

    } catch (Throwable $e) {
        error_log(
            'Daftar pembayaran gagal: ' . $e->getMessage()
        );

        http_response_code(500);
        exit('Daftar pembayaran belum dapat ditampilkan.');
    }
}
public function detail(): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('GET');

    $kodeSewa = trim((string) ($_GET['kode_sewa'] ?? ''));

    if ($kodeSewa === '') {
        header('Location: ' . site_url('pembayaran'));
        exit;
    }

    try {
        $pembayaran = $this->pembayaranModel
            ->getPembayaranPenyewaByKodeSewa(
                $kodeSewa,
                $userPlg
            );

        if ($pembayaran === null) {
            http_response_code(404);
            exit('Pembayaran tidak ditemukan atau bukan milik akun Anda.');
        }

        if (
            $pembayaran['mtode_byr'] !== 'transfer' ||
            $pembayaran['jns_byr'] !== 'dp'
        ) {
            http_response_code(403);
            exit('Pembayaran ini tidak dapat diakses melalui halaman ini.');
        }

        $flash = $_SESSION['flash_pembayaran'] ?? null;
        unset($_SESSION['flash_pembayaran']);

        $this->view('pembayaran/detail', [
            'pembayaran' => $pembayaran,
            'flash' => $flash
        ]);

    } catch (Throwable $e) {
        error_log(
            'Detail pembayaran gagal: ' . $e->getMessage()
        );

        http_response_code(500);
        exit('Detail pembayaran belum dapat ditampilkan.');
    }
}


    /**
     * Memproses unggahan bukti transfer.
     */
    /**
 * Menampilkan gambar bukti pembayaran milik penyewa.
 */
public function bukti(): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('GET');

    $kodeSewa = trim((string) ($_GET['kode_sewa'] ?? ''));

    if ($kodeSewa === '') {
        http_response_code(400);
        exit('Kode transaksi tidak ditemukan.');
    }

    $pembayaran = $this->pembayaranModel
        ->getPembayaranPenyewaByKodeSewa($kodeSewa, $userPlg);

    if (
        $pembayaran === null ||
        $pembayaran['mtode_byr'] !== 'transfer' ||
        $pembayaran['jns_byr'] !== 'dp' ||
        empty($pembayaran['ft_byr'])
    ) {
        http_response_code(404);
        exit('Bukti pembayaran tidak ditemukan.');
    }

    $namaFile = (string) $pembayaran['ft_byr'];

    // Pastikan nama file tidak dapat digunakan untuk mengakses folder lain.
    if (
        basename($namaFile) !== $namaFile ||
        !preg_match('/^ft_byr_\d{14}_[a-f0-9]{16}\.(jpg|png|webp)$/', $namaFile)
    ) {
        http_response_code(404);
        exit('Bukti pembayaran tidak valid.');
    }

    $path = dirname(APPPATH)
        . DIRECTORY_SEPARATOR . 'uploads'
        . DIRECTORY_SEPARATOR . 'bayar'
        . DIRECTORY_SEPARATOR . $namaFile;

    if (!is_file($path)) {
        http_response_code(404);
        exit('File bukti pembayaran tidak ditemukan.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($path);

    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
        http_response_code(415);
        exit('Format file bukti pembayaran tidak didukung.');
    }

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($path));
    header('Content-Disposition: inline; filename="' . $namaFile . '"');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store, no-cache, must-revalidate');

    readfile($path);
    exit;
}
    public function upload(): void
    {
        $userPlg = $this->wajibLoginPenyewa();
        $this->wajibMetode('POST');

        $kodeSewa = trim(
            (string) ($_POST['kode_sewa'] ?? '')
        );

        if ($kodeSewa === '') {
            $this->redirectDenganPesan(
                'katalog',
                'error',
                'Kode transaksi wajib diisi.'
            );
        }

        $fileBaru = null;

        try {
            // Periksa kepemilikan transaksi sebelum menerima file.
            $pembayaran = $this->pembayaranModel
                ->getPembayaranPenyewaByKodeSewa(
                    $kodeSewa,
                    $userPlg
                );

            if ($pembayaran === null) {
                http_response_code(404);
                exit(
                    'Pembayaran tidak ditemukan atau bukan milik akun Anda.'
                );
            }

            if (
                $pembayaran['mtode_byr'] !== 'transfer' ||
                $pembayaran['jns_byr'] !== 'dp'
            ) {
                http_response_code(403);
                exit('Jenis pembayaran tidak dapat diunggah melalui halaman ini.');
            }

            if (
                $pembayaran['sttus_byr'] !== 'pending' ||
                $pembayaran['status_sewa'] !== 'diajukan'
            ) {
                $this->redirectDenganPesan(
                   'pembayaran/detail?kode_sewa=' . rawurlencode($kodeSewa),
                    'error',
                    'Pembayaran ini sudah tidak dapat diubah.'
                );
            }

            // Validasi file yang dikirim.
            $hasilUpload = $this->uploadBuktiPembayaran('ft_byr');

            if (!$hasilUpload['success']) {
                $this->redirectDenganPesan(
                    'pembayaran/detail?kode_sewa=' . rawurlencode($kodeSewa),
                    'error',
                    $hasilUpload['error']
                );
            }

            $fileBaru = $hasilUpload['filename'];

            // Memperbarui record DP yang sudah ada.
            $berhasil = $this->pembayaranModel
                ->simpanBuktiPembayaran(
                    (string) $pembayaran['kode_bayar'],
                    $userPlg,
                    $fileBaru
                );

            if (!$berhasil) {
                $this->hapusFileBukti($fileBaru);
                $fileBaru = null;

                $this->redirectDenganPesan(
                    'pembayaran/detail?kode_sewa=' . rawurlencode($kodeSewa),
                    'error',
                    'Bukti pembayaran belum berhasil disimpan. Periksa kembali status transaksi.'
                );
            }

            $this->redirectDenganPesan(
                'pembayaran/detail?kode_sewa=' . rawurlencode($kodeSewa),
                'success',
                'Bukti transfer berhasil diunggah. Pembayaran menunggu verifikasi admin.'
            );
        } catch (Throwable $e) {
            if ($fileBaru !== null) {
                $this->hapusFileBukti($fileBaru);
            }

            error_log(
                'Unggah bukti pembayaran gagal: ' . $e->getMessage()
            );

            $this->redirectDenganPesan(
                'pembayaran/detail?kode_sewa=' . rawurlencode($kodeSewa),
                'error',
                'Bukti pembayaran gagal diunggah. Silakan coba kembali.'
            );
        }
    }

    /**
     * Validasi dan penyimpanan gambar bukti pembayaran.
     */
    private function uploadBuktiPembayaran(string $field): array
    {
        if (
            !isset($_FILES[$field]) ||
            ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE)
                === UPLOAD_ERR_NO_FILE
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Pilih gambar bukti transfer terlebih dahulu.'
            ];
        }

        $file = $_FILES[$field];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Unggah bukti pembayaran gagal. Periksa ukuran file dan konfigurasi PHP.'
            ];
        }

        if (
            !isset($file['tmp_name'], $file['size']) ||
            !is_uploaded_file($file['tmp_name']) ||
            (int) $file['size'] < 1 ||
            (int) $file['size'] > 5 * 1024 * 1024
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Bukti pembayaran harus lebih dari 0 byte dan maksimal 5 MB.'
            ];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (
            !isset($allowed[$mime]) ||
            @getimagesize($file['tmp_name']) === false
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Format bukti pembayaran harus berupa gambar JPEG, PNG, atau WEBP yang valid.'
            ];
        }

        $uploadDir = dirname(APPPATH)
            . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'bayar'
            . DIRECTORY_SEPARATOR;

        if (
            !is_dir($uploadDir) &&
            !mkdir($uploadDir, 0755, true) &&
            !is_dir($uploadDir)
        ) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Folder penyimpanan bukti pembayaran tidak dapat dibuat.'
            ];
        }

        if (!is_writable($uploadDir)) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Folder penyimpanan bukti pembayaran tidak dapat ditulis.'
            ];
        }

        try {
            $filename = 'ft_byr_'
                . date('YmdHis')
                . '_'
                . bin2hex(random_bytes(8))
                . '.'
                . $allowed[$mime];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Nama file bukti pembayaran gagal dibuat.'
            ];
        }

        if (!move_uploaded_file(
            $file['tmp_name'],
            $uploadDir . $filename
        )) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Bukti pembayaran gagal disimpan ke folder.'
            ];
        }

        return [
            'success' => true,
            'filename' => $filename,
            'error' => null
        ];
    }

    /**
     * Menghapus file baru jika proses database gagal.
     */
    private function hapusFileBukti(string $filename): void
    {
        if (
            !preg_match(
                '/^ft_byr_\d{14}_[a-f0-9]{16}\.(jpg|png|webp)$/',
                $filename
            )
        ) {
            return;
        }

        $path = dirname(APPPATH)
            . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'bayar'
            . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function wajibLoginPenyewa(): string
    {
        $userPlg = trim(
            (string) ($_SESSION['penyewa_user_plg'] ?? '')
        );

        if ($userPlg === '') {
            $_SESSION['flash_penyewa_nav'] =
                'Silakan login terlebih dahulu untuk mengakses pembayaran.';

            header('Location: ' . site_url('auth/login-penyewa'));
            exit;
        }

        return $userPlg;
    }

    private function wajibMetode(string $metodeDiizinkan): void
    {
        $metodeAktif = strtoupper(
            (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')
        );

        if ($metodeAktif !== $metodeDiizinkan) {
            http_response_code(405);
            header('Allow: ' . $metodeDiizinkan);
            exit('Method Not Allowed');
        }
    }

    private function redirectDenganPesan(
        string $uri,
        string $jenis,
        string $pesan
    ): never {
        $_SESSION['flash_pembayaran'] = [
            'type' => $jenis,
            'message' => $pesan
        ];

        header('Location: ' . site_url($uri));
        exit;
    }
}
