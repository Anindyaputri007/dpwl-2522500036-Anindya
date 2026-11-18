
<?php

class Verifikasi_pembayaran_model
{
    private mysqli $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // Mengambil daftar pembayaran DP yang menunggu verifikasi admin.
    public function getPembayaranMenungguVerifikasi(): array
    {
        $sql = "SELECT
                    b.kode_bayar,
                    b.kode_sewa,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    p.user_plg,
                    p.nm_lngkp,
                    p.no_hp
                FROM t_bayar b
                INNER JOIN t_sewa s
                    ON s.kode_sewa = b.kode_sewa
                INNER JOIN t_penyewa p
                    ON p.user_plg = s.user_plg
                WHERE b.jns_byr = 'dp'
                  AND b.mtode_byr = 'transfer'
                  AND b.sttus_byr = 'pending'
                  AND b.ft_byr IS NOT NULL
                  AND b.ft_byr <> ''
                  AND s.status_sewa = 'diajukan'
                ORDER BY b.tgl_wkt_byr ASC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Daftar pembayaran gagal disiapkan.'
            );
        }

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Daftar pembayaran gagal diambil.'
            );
        }

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data;
    }

    // Memverifikasi atau menolak pembayaran.
    public function verifikasiPembayaran(
        string $kodeBayar,
        string $aksi
    ): bool {
        if (!in_array($aksi, ['terima', 'tolak'], true)) {
            return false;
        }

        $statusBayar = $aksi === 'terima' ? 'valid' : 'invalid';
        $statusSewa = $aksi === 'terima' ? 'disetujui' : 'ditolak';

        $this->db->begin_transaction();

        try {
            // Mengunci data pembayaran agar tidak diverifikasi dua kali.
            $stmt = $this->db->prepare(
                "SELECT
                    b.kode_sewa,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.sttus_byr,
                    s.status_sewa
                 FROM t_bayar b
                 INNER JOIN t_sewa s
                    ON s.kode_sewa = b.kode_sewa
                 WHERE b.kode_bayar = ?
                 FOR UPDATE"
            );

            if (!$stmt) {
                throw new RuntimeException(
                    'Data pembayaran gagal disiapkan.'
                );
            }

            $stmt->bind_param('s', $kodeBayar);

            if (!$stmt->execute()) {
                $stmt->close();

                throw new RuntimeException(
                    'Data pembayaran gagal diperiksa.'
                );
            }

            $pembayaran = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // Pastikan pembayaran memenuhi syarat verifikasi.
            if (
                !$pembayaran ||
                $pembayaran['jns_byr'] !== 'dp' ||
                $pembayaran['mtode_byr'] !== 'transfer' ||
                $pembayaran['sttus_byr'] !== 'pending' ||
                empty($pembayaran['ft_byr']) ||
                $pembayaran['status_sewa'] !== 'diajukan'
            ) {
                $this->db->rollback();
                return false;
            }

            // Memperbarui status pembayaran.
            $stmt = $this->db->prepare(
                "UPDATE t_bayar
                 SET sttus_byr = ?,
                     tgl_wkt_ver = NOW()
                 WHERE kode_bayar = ?
                   AND sttus_byr = 'pending'
                   AND ft_byr IS NOT NULL
                   AND ft_byr <> ''"
            );

            if (!$stmt) {
                throw new RuntimeException(
                    'Pembaruan pembayaran gagal disiapkan.'
                );
            }

            $stmt->bind_param(
                'ss',
                $statusBayar,
                $kodeBayar
            );

            if (!$stmt->execute()) {
                $stmt->close();

                throw new RuntimeException(
                    'Pembaruan pembayaran gagal.'
                );
            }

            $berhasilBayar = $stmt->affected_rows === 1;
            $stmt->close();

            if (!$berhasilBayar) {
                $this->db->rollback();
                return false;
            }

            // Memperbarui status transaksi sewa.
            $kodeSewa = (string) $pembayaran['kode_sewa'];

            $stmt = $this->db->prepare(
                "UPDATE t_sewa
                 SET status_sewa = ?
                 WHERE kode_sewa = ?
                   AND status_sewa = 'diajukan'"
            );

            if (!$stmt) {
                throw new RuntimeException(
                    'Pembaruan status sewa gagal disiapkan.'
                );
            }

            $stmt->bind_param(
                'ss',
                $statusSewa,
                $kodeSewa
            );

            if (!$stmt->execute()) {
                $stmt->close();

                throw new RuntimeException(
                    'Pembaruan status sewa gagal.'
                );
            }

            $berhasilSewa = $stmt->affected_rows === 1;
            $stmt->close();

            if (!$berhasilSewa) {
                $this->db->rollback();
                return false;
            }

            $this->db->commit();

            return true;

        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

public function getBuktiPembayaranAdmin(string $kodeBayar): ?string
{
    $stmt = $this->db->prepare(
        "SELECT b.ft_byr
         FROM t_bayar b
         INNER JOIN t_sewa s
            ON s.kode_sewa = b.kode_sewa
         WHERE b.kode_bayar = ?
           AND b.jns_byr = 'dp'
           AND b.mtode_byr = 'transfer'

           AND b.ft_byr IS NOT NULL
           AND b.ft_byr <> ''
           
         LIMIT 1"
    );

    if (!$stmt) {
        throw new RuntimeException('Pencarian bukti pembayaran gagal disiapkan.');
    }

    $stmt->bind_param('s', $kodeBayar);

    if (!$stmt->execute()) {
        $stmt->close();
        throw new RuntimeException('Pencarian bukti pembayaran gagal.');
    }

    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $data ? (string) $data['ft_byr'] : null;
}

}
