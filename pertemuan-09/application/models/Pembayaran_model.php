
<?php

class Pembayaran_model
{
    private mysqli $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getPembayaranPenyewaByKodeBayar(
        string $kodeBayar,
        string $userPlg
    ): ?array {
        return $this->getPembayaranPenyewa(
            'b.kode_bayar',
            $kodeBayar,
            $userPlg
        );
    }

    public function getPembayaranPenyewaByKodeSewa(
        string $kodeSewa,
        string $userPlg
    ): ?array {
        return $this->getPembayaranPenyewa(
            'b.kode_sewa',
            $kodeSewa,
            $userPlg
        );
    }

    private function getPembayaranPenyewa(
        string $kolomKunci,
        string $nilaiKunci,
        string $userPlg
    ): ?array {
        // Kolom pencarian hanya boleh berasal dari dua method di atas.
        if (!in_array(
            $kolomKunci,
            ['b.kode_bayar', 'b.kode_sewa'],
            true
        )) {
            throw new InvalidArgumentException(
                'Kunci pencarian pembayaran tidak valid.'
            );
        }

        $sql = "SELECT
                    b.kode_bayar,
                    b.tgl_wkt_byr,
                    b.ft_byr,
                    b.mtode_byr,
                    b.jns_byr,
                    b.nominal,
                    b.sttus_byr,
                    b.tgl_wkt_ver,
                    b.kode_sewa,
                    s.tgl_mulai,
                    s.tgl_selesai,
                    s.wkt_ambil,
                    s.status_sewa,
                    s.user_plg,
                    p.nm_lngkp,
                    p.no_hp
                FROM t_bayar b
                INNER JOIN t_sewa s
                    ON s.kode_sewa = b.kode_sewa
                INNER JOIN t_penyewa p
                    ON p.user_plg = s.user_plg
                WHERE {$kolomKunci} = ?
                  AND s.user_plg = ?
                  AND b.jns_byr = 'dp'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Pencarian pembayaran gagal disiapkan.'
            );
        }

        $stmt->bind_param('ss', $nilaiKunci, $userPlg);

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Pencarian pembayaran gagal dijalankan.'
            );
        }

        $pembayaran = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($pembayaran === null) {
            return null;
        }

        // Mengambil rincian kendaraan dari transaksi.
        $stmt = $this->db->prepare(
            "SELECT
                p.no_plat,
                p.hrg_sewa,
                p.n_hari,
                m.nm_mobil
             FROM t_pilih p
             INNER JOIN t_mobil m
                ON m.no_plat = p.no_plat
             WHERE p.kode_sewa = ?
             ORDER BY m.nm_mobil ASC"
        );

        if (!$stmt) {
            throw new RuntimeException(
                'Rincian kendaraan gagal disiapkan.'
            );
        }

        $kodeSewa = (string) $pembayaran['kode_sewa'];

        $stmt->bind_param('s', $kodeSewa);

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Rincian kendaraan gagal diambil.'
            );
        }

        $detail = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $totalSewa = 0;

        foreach ($detail as $item) {
            $totalSewa +=
                (int) $item['hrg_sewa'] *
                (int) $item['n_hari'];
        }

        $pembayaran['detail'] = $detail;
        $pembayaran['total_sewa'] = $totalSewa;

        return $pembayaran;
    }

    public function simpanBuktiPembayaran(
        string $kodeBayar,
        string $userPlg,
        string $namaFile
    ): bool {
        $stmt = $this->db->prepare(
            "UPDATE t_bayar b
             INNER JOIN t_sewa s
                ON s.kode_sewa = b.kode_sewa
             SET
                b.ft_byr = ?,
                b.tgl_wkt_byr = NOW()
             WHERE b.kode_bayar = ?
               AND b.jns_byr = 'dp'
               AND b.mtode_byr = 'transfer'
               AND b.sttus_byr = 'pending'
               AND s.user_plg = ?
               AND s.status_sewa = 'diajukan'"
        );

        if (!$stmt) {
            throw new RuntimeException(
                'Penyimpanan bukti pembayaran gagal disiapkan.'
            );
        }

        $stmt->bind_param(
            'sss',
            $namaFile,
            $kodeBayar,
            $userPlg
        );

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Penyimpanan bukti pembayaran gagal dijalankan.'
            );
        }

        $berhasil = $stmt->affected_rows === 1;
        $stmt->close();

        return $berhasil;
    }
}
