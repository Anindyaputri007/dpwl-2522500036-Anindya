
<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$penyewa_dipilih = $penyewa_dipilih ?? [];
$error = $error ?? null;

$e = static function ($value): string {
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Tambah Penyewa
            <small>Form data penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= $e(site_url('admin')) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= $e(site_url('admin/penyewa')) ?>">
                    Manajemen Penyewa
                </a>
            </li>
            <li class="active">Tambah Penyewa</li>
        </ol>
    </section>

    <section class="content">

        <?php if ($error !== null): ?>
            <div class="alert alert-danger">
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Penyewa</h3>
            </div>

           <form method="post"
                 autocomplete="off"
                action="<?= $e(site_url('admin/penyewa/tambah')) ?>">

                <div class="box-body">

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text"
                            name="user_plg"
                            class="form-control"
                            maxlength="15"
                            autocomplete="new-username"
                            required
                            value="<?= $e($penyewa_dipilih['user_plg'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password"
                            name="sandi"
                            class="form-control"
                            autocomplete="new-password"
                            required>
                            
                    </div>

                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text"
                            name="nik"
                            class="form-control"
                            maxlength="16"
                            required
                            value="<?= $e($penyewa_dipilih['nik'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text"
                            name="nm_lngkp"
                            class="form-control"
                            maxlength="100"
                            required
                            value="<?= $e($penyewa_dipilih['nm_lngkp'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text"
                            name="no_hp"
                            class="form-control"
                            maxlength="15"
                            required
                            value="<?= $e($penyewa_dipilih['no_hp'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="almt_lngkp"
                            class="form-control"
                            rows="3"
                            maxlength="300"
                            required><?= $e($penyewa_dipilih['almt_lngkp'] ?? '') ?></textarea>
                    </div>

                </div>

                <div class="box-footer">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>

                    <a href="<?= $e(site_url('admin/penyewa')) ?>"
                        class="btn btn-default">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>
