
<?php

// UTS: CRUD Manajemen Penyewa
class Manajemen_penyewa_controller extends Controller
{
    private Manajemen_penyewa_model $model;

    public function __construct()
    {
        require_once APPPATH . 'models/Manajemen_penyewa_model.php';
        require_once APPPATH . 'helpers/auth_helper.php';
        require_once APPPATH . 'helpers/flash_helper.php';

        $this->model = new Manajemen_penyewa_model();
    }

    // Menampilkan halaman daftar penyewa.
    public function index(): void
    {
        require_admin_login();

        $this->view('admin/manajemen_penyewa_view', [
            'username' => $_SESSION['admin_username'],
            'penyewa' => $this->model->getAll(),
            'flash' => get_flash_message(),
            'mode' => null,
            'penyewa_dipilih' => null,
            'error' => null,
        ]);
    }
    
    // Menampilkan form tambah dan menyimpan data penyewa baru.
    public function tambah(): void
    {
        require_admin_login();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userPlg = trim($_POST['user_plg'] ?? '');
            $sandi = $_POST['sandi'] ?? '';
            $nik = trim($_POST['nik'] ?? '');
            $nmLngkp = trim($_POST['nm_lngkp'] ?? '');
            $noHp = trim($_POST['no_hp'] ?? '');
            $almtLngkp = trim($_POST['almt_lngkp'] ?? '');

            if (
                $userPlg === '' ||
                $sandi === '' ||
                $nik === '' ||
                $nmLngkp === '' ||
                $noHp === '' ||
                $almtLngkp === ''
            ) {
                $error = 'Semua kolom wajib diisi.';
            try {
    // Periksa apakah username sudah digunakan
    if ($this->model->findByUserPlg($userPlg) !== null) {

        $error = 'Username sudah digunakan. Silakan gunakan username lain.';

    } else {

        $data = [
            'user_plg' => $userPlg,
            'sandi' => password_hash(
                $sandi,
                PASSWORD_DEFAULT
            ),
            'nik' => $nik,
            'nm_lngkp' => $nmLngkp,
            'no_hp' => $noHp,
            'almt_lngkp' => $almtLngkp,
            'ft_ktp' => null,
            'ft_sim_a' => null,
        ];

        $berhasil = $this->model->create($data);

        if ($berhasil) {
            set_flash_message(
                'success',
                'Data penyewa berhasil ditambahkan.'
            );

            redirect(site_url('admin/penyewa'));
            return;
        }

        $error = 'Data penyewa gagal ditambahkan.';
    }

} catch (Throwable $e) {
    $error = $e->getMessage();
}
            }
        }

        $this->view('admin/manajemen_penyewa_form', [
            'username' => $_SESSION['admin_username'],
            'mode' => 'tambah',
            'penyewa_dipilih' => null,
            'error' => $error ?? null,
        ]);
    }

}
