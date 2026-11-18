<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

require APPPATH . 'views/katalog/navbar.php';

$formatRupiah = static function ($nilai): string {
    return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
};

$pembayaran = is_array($pembayaran ?? null) ? $pembayaran : [];
$detail = is_array($pembayaran['detail'] ?? null)
    ? $pembayaran['detail']
    : [];

$kodeSewa = (string) ($pembayaran['kode_sewa'] ?? '');
$kodeBayar = (string) ($pembayaran['kode_bayar'] ?? '');
$statusBayar = (string) ($pembayaran['sttus_byr'] ?? '');
$statusSewa = (string) ($pembayaran['status_sewa'] ?? '');

$flash = is_array($flash ?? null) ? $flash : [];
$pesanFlash = $flash['pesan'] ?? $flash['message'] ?? '';
$tipeFlash = $flash['tipe'] ?? $flash['type'] ?? 'info';

$statusLabel = [
    'pending' => 'Menunggu Verifikasi',
    'valid' => 'Pembayaran Valid',
    'invalid' => 'Pembayaran Ditolak',
];

$statusClass = [
    'pending' => 'warning',
    'valid' => 'success',
    'invalid' => 'danger',
];
?>

<section class="bg-success py-4">
    <div class="container">
        <h1 class="h2 text-white mt-3">Pembayaran Uang Muka</h1>
        <p class="text-white mb-0">
            Lihat rincian pembayaran dan unggah bukti transfer uang muka.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <?php if ($pesanFlash !== ''): ?>
            <div class="alert alert-<?= $e($tipeFlash) ?> alert-dismissible fade show"
                 role="alert">
                <?= $e($pesanFlash) ?>
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h2 class="h5 mb-0">Informasi Transaksi</h2>
            </div>

            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Kode transaksi</dt>
                    <dd class="col-sm-8"><?= $e($kodeSewa) ?></dd>

                    <dt class="col-sm-4">Kode pembayaran</dt>
                    <dd class="col-sm-8"><?= $e($kodeBayar) ?></dd>

                    <dt class="col-sm-4">Nama penyewa</dt>
                    <dd class="col-sm-8">
                        <?= $e($pembayaran['nm_lngkp'] ?? '-') ?>
                    </dd>

                    <dt class="col-sm-4">Tanggal mulai</dt>
                    <dd class="col-sm-8">
                        <?= $e($pembayaran['tgl_mulai'] ?? '-') ?>
                    </dd>

                    <dt class="col-sm-4">Tanggal selesai</dt>
                    <dd class="col-sm-8">
                        <?= $e($pembayaran['tgl_selesai'] ?? '-') ?>
                    </dd>

                    <dt class="col-sm-4">Metode pembayaran</dt>
                    <dd class="col-sm-8">
                        <?= $e(ucfirst($pembayaran['mtode_byr'] ?? '-')) ?>
                    </dd>

                    <dt class="col-sm-4">Status transaksi</dt>
                    <dd class="col-sm-8">
                        <?= $e(ucfirst($statusSewa)) ?>
                    </dd>

                    <dt class="col-sm-4">Status pembayaran</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $e($statusClass[$statusBayar] ?? 'secondary') ?>">
                            <?= $e($statusLabel[$statusBayar] ?? $statusBayar) ?>
                        </span>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h2 class="h5 mb-0">Rincian Kendaraan</h2>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kendaraan</th>
                                <th>Nomor Polisi</th>
                                <th class="text-end">Harga per Hari</th>
                                <th class="text-center">Durasi</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $item): ?>
                                <?php
                                $harga = (int) ($item['hrg_sewa'] ?? 0);
                                $hari = (int) ($item['n_hari'] ?? 0);
                                $subtotal = $harga * $hari;
                                ?>
                                <tr>
                                    <td><?= $e($item['nm_mobil'] ?? '-') ?></td>
                                    <td><?= $e($item['no_plat'] ?? '-') ?></td>
                                    <td class="text-end text-nowrap">
                                        <?= $e($formatRupiah($harga)) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $e($hari) ?> hari
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <?= $e($formatRupiah($subtotal)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row justify-content-end mb-4">
            <div class="col-lg-6 col-xl-5">
                <div class="card border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-3 mb-2">
                            <span>Total sewa</span>
                            <strong class="text-nowrap">
                                <?= $e($formatRupiah($pembayaran['total_sewa'] ?? 0)) ?>
                            </strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between gap-3">
                            <span>Uang muka (DP)</span>
                            <strong class="text-success text-nowrap">
                                <?= $e($formatRupiah($pembayaran['nominal'] ?? 0)) ?>
                            </strong>
                        </div>

                        <p class="small text-muted mt-3 mb-0">
                            Nominal pembayaran diambil langsung dari database
                            dan tidak dapat diubah melalui halaman ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($statusBayar === 'pending'
            && ($pembayaran['mtode_byr'] ?? '') === 'transfer'
            && $statusSewa === 'diajukan'): ?>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h2 class="h5 mb-0">Unggah Bukti Pembayaran</h2>
                </div>

                <div class="card-body">
                    <?php if (!empty($pembayaran['ft_byr'])): ?>
                        <div class="card-body">
    <?php if (!empty($pembayaran['ft_byr'])): ?>

        <div class="alert alert-info">
            Bukti pembayaran sudah diunggah.
            Silakan tunggu verifikasi dari admin.
        </div>

        <h3 class="h6 mb-3">Bukti Transfer yang Diunggah</h3>

        <div class="text-center">
            <img
                src="<?= $e(
                    site_url('pembayaran/bukti?kode_sewa=')
                    . rawurlencode($kodeSewa)
                ) ?>"
                alt="Bukti transfer pembayaran"
                class="img-fluid rounded border"
                style="max-width: 600px; max-height: 500px;"
            >
        </div>

    <?php else: ?>

        <p>
            Silakan unggah bukti transfer uang muka.
            Format file yang diperbolehkan adalah JPG,
            PNG, atau WEBP dengan ukuran maksimal 5 MB.
        </p>

        <form method="post"
              action="<?= $e(site_url('pembayaran/upload')) ?>"
              enctype="multipart/form-data">

            <input type="hidden" name="kode_sewa"
                   value="<?= $e($kodeSewa) ?>">

            <div class="mb-3">
                <label for="ft_byr" class="form-label">
                    File Bukti Pembayaran
                </label>
                <input type="file"
                       class="form-control"
                       id="ft_byr"
                       name="ft_byr"
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                       required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-upload me-1" aria-hidden="true"></i>
                Unggah Bukti Pembayaran
            </button>
        </form>

    <?php endif; ?>
</div>
                    <?php else: ?>
                        <p>
                            Silakan unggah bukti transfer uang muka.
                            Format file yang diperbolehkan adalah JPG,
                            PNG, atau WEBP dengan ukuran maksimal 5 MB.
                        </p>
                    <?php endif; ?>

                    <form method="post"
                          action="<?= $e(site_url('pembayaran/upload')) ?>"
                          enctype="multipart/form-data">

                        <input type="hidden" name="kode_sewa"
                               value="<?= $e($kodeSewa) ?>">

                        <div class="mb-3">
                            <label for="ft_byr" class="form-label">
                                File Bukti Pembayaran
                            </label>
                            <input type="file"
                                   class="form-control"
                                   id="ft_byr"
                                   name="ft_byr"
                                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-1" aria-hidden="true"></i>
                            Unggah Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>

        <?php elseif ($statusBayar === 'valid'): ?>

            <div class="alert alert-success">
                Pembayaran uang muka telah dinyatakan valid oleh admin.
            </div>

        <?php elseif ($statusBayar === 'invalid'): ?>

            <div class="alert alert-danger">
                Pembayaran uang muka ditolak oleh admin.
            </div>

        <?php endif; ?>

        <a href="<?= $e(site_url('katalog')) ?>"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1" aria-hidden="true"></i>
            Kembali ke Katalog
        </a>

    </div>
</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>
