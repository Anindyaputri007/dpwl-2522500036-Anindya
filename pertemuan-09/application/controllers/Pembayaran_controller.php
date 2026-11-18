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
    
public function index(string $kodeSewa = ''): void
{
    $userPlg = $this->wajibLoginPenyewa();
    $this->wajibMetode('GET');

    $kodeSewa = trim(
        $kodeSewa !== ''
            ? $kodeSewa
            : (string) ($_GET['kode_sewa'] ?? '')
    );

    try {
        // Jika kode sewa kosong, ambil pembayaran terbaru.
        if ($kodeSewa === '') {
            $pembayaran = $this->pembayaranModel
                ->getPembayaranTerbaruPenyewa($userPlg);
        } else {
            // Jika kode sewa tersedia, cari berdasarkan kode tersebut.
            $pembayaran = $this->pembayaranModel
                ->getPembayaranPenyewaByKodeSewa(
                    $kodeSewa,
                    $userPlg
                );
        }

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
            exit('Pembayaran ini tidak dapat diakses melalui halaman ini.');
        }

        $flash = $_SESSION['flash_pembayaran'] ?? null;
        unset($_SESSION['flash_pembayaran']);

        $this->view('pembayaran/index', [
            'pembayaran' => $pembayaran,
            'flash' => $flash
        ]);

    } catch (Throwable $e) {
        error_log(
            'Tampilan pembayaran gagal: ' . $e->getMessage()
        );

        http_response_code(500);
        exit(
            'Halaman pembayaran belum dapat ditampilkan. Silakan coba kembali.'
        );
    }
}


    /**
     * Memproses unggahan bukti transfer.
     */
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
                    'pembayaran?kode_sewa=' . rawurlencode($kodeSewa),
                    'error',
                    'Pembayaran ini sudah tidak dapat diubah.'
                );
            }

            // Validasi file yang dikirim.
            $hasilUpload = $this->uploadBuktiPembayaran('ft_byr');

            if (!$hasilUpload['success']) {
                $this->redirectDenganPesan(
                    'pembayaran?kode_sewa=' . rawurlencode($kodeSewa),
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
                    'pembayaran?kode_sewa=' . rawurlencode($kodeSewa),
                    'error',
                    'Bukti pembayaran belum berhasil disimpan. Periksa kembali status transaksi.'
                );
            }

            $this->redirectDenganPesan(
                'pembayaran?kode_sewa=' . rawurlencode($kodeSewa),
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
                'pembayaran?kode_sewa=' . rawurlencode($kodeSewa),
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
