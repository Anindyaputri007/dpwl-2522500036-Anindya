
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
}
