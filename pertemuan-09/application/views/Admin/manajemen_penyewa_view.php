
<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$penyewa = $penyewa ?? [];
$flash = $flash ?? null;
$error = $error ?? null;

$mode = $mode ?? null;
$penyewa_dipilih = $penyewa_dipilih ?? null;

$flashClass = (($flash['type'] ?? '') === 'success')
    ? 'alert-success'
    : 'alert-danger';

$e = static function ($value): string {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <h1>
            Manajemen Penyewa
            <small>Kelola data penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= $e(site_url('admin')) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Manajemen Penyewa</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">

        <!-- Flash Message -->
        <?php if (!empty($flash)): ?>
            <div class="alert <?= $flashClass ?> alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <i class="fa <?= (($flash['type'] ?? '') === 'success')
                    ? 'fa-check'
                    : 'fa-warning' ?>"></i>

                <?= $e($flash['message'] ?? '') ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if ($error !== null): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <i class="fa fa-warning"></i>
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <!-- Data Penyewa -->
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">Data Penyewa</h3>

                <div class="box-tools">
                    <a href="<?= $e(site_url('admin/penyewa/tambah')) ?>"
                        class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Penyewa
                    </a>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped js-data-table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Foto KTP</th>
                                <th>Foto SIM A</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($penyewa as $no => $item): ?>
                                <tr>
                                    <td><?= (int) $no + 1 ?></td>

                                    <td><?= $e($item['user_plg'] ?? '') ?></td>

                                    <td><?= $e($item['nik'] ?? '') ?></td>

                                    <td><?= $e($item['nm_lngkp'] ?? '') ?></td>

                                    <td><?= $e($item['no_hp'] ?? '') ?></td>

                                    <td><?= $e($item['almt_lngkp'] ?? '') ?></td>

                                    <td>
                                        <?php if (!empty($item['ft_ktp'])): ?>
                                            <span class="label label-success">
                                                Tersedia
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-default">
                                                Belum ada
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($item['ft_sim_a'])): ?>
                                            <span class="label label-success">
                                                Tersedia
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-default">
                                                Belum ada
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a class="btn btn-warning btn-xs"
                                            href="<?= $e(site_url(
                                                'admin/penyewa/ubah/' .
                                                rawurlencode((string) ($item['user_plg'] ?? ''))
                                            )) ?>">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>

                                        <form method="post"
                                            style="display:inline"
                                            action="<?= $e(site_url(
                                                'admin/penyewa/hapus/' .
                                                rawurlencode((string) ($item['user_plg'] ?? ''))
                                            )) ?>"
                                            onsubmit="return confirm('Hapus data penyewa ini?');">

                                            <button type="submit"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Foto KTP</th>
                                <th>Foto SIM A</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>

                    </table>

                </div>
            </div>
        </div>

    </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>
