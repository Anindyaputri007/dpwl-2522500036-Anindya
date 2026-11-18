
<?php
require APPPATH . 'views/katalog/header.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

require APPPATH . 'views/katalog/navbar.php';

$pembayaran = is_array($pembayaran ?? null) ? $pembayaran : [];
$flash = is_array($flash ?? null) ? $flash : [];

$pesanFlash = $flash['message'] ?? $flash['pesan'] ?? '';
$tipeFlash = $flash['type'] ?? $flash['tipe'] ?? 'info';

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
        <h1 class="h2 text-white mt-3">Daftar Pembayaran</h1>
        <p class="text-white mb-0">
            Lihat daftar transaksi dan status pembayaran uang muka.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <?php if ($pesanFlash !== ''): ?>
            <div class="alert alert-<?= $e($tipeFlash) ?> alert-dismissible fade show">
                <?= $e($pesanFlash) ?>
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Nominal DP</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pembayaran)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Belum ada data pembayaran.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pembayaran as $i => $item): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $e($item['kode_sewa']) ?></td>
                                        <td><?= $e($item['tgl_mulai'] ?? '-') ?></td>
                                        <td><?= $e($item['tgl_selesai'] ?? '-') ?></td>
                                        <td class="text-nowrap">
                                            Rp <?= number_format(
                                                (float) $item['nominal'],
                                                0, ',', '.'
                                            ) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $e(
                                                $statusClass[$item['sttus_byr']] ?? 'secondary'
                                            ) ?>">
                                                <?= $e(
                                                    $statusLabel[$item['sttus_byr']]
                                                    ?? $item['sttus_byr']
                                                ) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= $e(
                                                site_url(
                                                    'pembayaran/detail?kode_sewa=' .
                                                    rawurlencode($item['kode_sewa'])
                                                )
                                            ) ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="<?= $e(site_url('katalog')) ?>"
           class="btn btn-outline-secondary mt-3">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali ke Katalog
        </a>

    </div>
</section>

<?php require APPPATH . 'views/katalog/footer.php'; ?>
