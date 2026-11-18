
<?php
require APPPATH . '/views/templates/header.php';
require APPPATH . '/views/templates/sidebar.php';

$pembayaran = $pembayaran ?? [];
$flash = $flash ?? null;
$error = $error ?? null;

$flashClass = (($flash['type'] ?? '') === 'success')
    ? 'alert-success'
    : 'alert-danger';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Verifikasi Pembayaran
            <small>Kelola pembayaran penyewa</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= $e(site_url('admin')) ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Verifikasi Pembayaran</li>
        </ol>
    </section>

    <section class="content">

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

        <?php if ($error !== null): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close"
                    data-dismiss="alert" aria-hidden="true">&times;</button>

                <i class="fa fa-warning"></i>
                <?= $e($error) ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">
                    Daftar Pembayaran Menunggu Verifikasi
                </h3>
            </div>

            <div class="box-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Pembayaran</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Penyewa</th>
                                <th>Username</th>
                                <th>No. HP</th>
                                <th>Nominal DP</th>
                                <th>Waktu Pembayaran</th>
                                <th>Bukti Transfer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (empty($pembayaran)): ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Belum ada pembayaran yang menunggu verifikasi.
                                    </td>
                                </tr>
                            <?php else: ?>

                                <?php foreach ($pembayaran as $no => $item): ?>
                                    <tr>
                                        <td><?= (int) $no + 1 ?></td>

                                        <td><?= $e($item['kode_bayar']) ?></td>

                                        <td><?= $e($item['kode_sewa']) ?></td>

                                        <td><?= $e($item['nm_lngkp']) ?></td>

                                        <td><?= $e($item['user_plg']) ?></td>

                                        <td><?= $e($item['no_hp']) ?></td>

                                        <td>
                                            Rp <?= number_format(
                                                (int) $item['nominal'],
                                                0,
                                                ',',
                                                '.'
                                            ) ?>
                                        </td>

                                        <td><?= $e($item['tgl_wkt_byr']) ?></td>

                                        <td>
                                            <a
                                                href="<?= $e(site_url(
    'admin/pembayaran/bukti?kode_bayar=' .
    rawurlencode($item['kode_bayar'])
)) ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="btn btn-info btn-xs">
                                                <i class="fa fa-image"></i>
                                                Lihat Bukti
                                            </a>
                                        </td>

                                        <td>
                                            <form
                                                method="post"
                                                action="<?= $e(site_url('admin/pembayaran/verifikasi')) ?>"
                                                style="display:inline;"
                                                onsubmit="return confirm('Terima pembayaran ini?');">

                                                <input
                                                    type="hidden"
                                                    name="kode_bayar"
                                                    value="<?= $e($item['kode_bayar']) ?>">

                                                <input
                                                    type="hidden"
                                                    name="aksi"
                                                    value="terima">

                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-xs">
                                                    <i class="fa fa-check"></i>
                                                    Terima
                                                </button>
                                            </form>

                                            <form
                                                method="post"
                                                action="<?= $e(site_url('admin/pembayaran/verifikasi')) ?>"
                                                style="display:inline;"
                                                onsubmit="return confirm('Tolak pembayaran ini?');">

                                                <input
                                                    type="hidden"
                                                    name="kode_bayar"
                                                    value="<?= $e($item['kode_bayar']) ?>">

                                                <input
                                                    type="hidden"
                                                    name="aksi"
                                                    value="tolak">

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-xs">
                                                    <i class="fa fa-times"></i>
                                                    Tolak
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </section>
</div>

<?php
require APPPATH . '/views/templates/footer.php';
?>
