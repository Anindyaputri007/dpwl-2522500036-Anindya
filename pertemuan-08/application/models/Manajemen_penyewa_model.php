
<?php

class Manajemen_penyewa_model
{
    private mysqli $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // Mengambil seluruh data penyewa untuk halaman admin.
    public function getAll(): array
    {
        $sql = "SELECT
                    user_plg,
                    nik,
                    nm_lngkp,
                    no_hp,
                    almt_lngkp,
                    ft_ktp,
                    ft_sim_a
                FROM t_penyewa
                ORDER BY nm_lngkp ASC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query data penyewa gagal disiapkan.'
            );
        }

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Data penyewa gagal diambil.'
            );
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $data;
    }

    // Mengambil satu data penyewa berdasarkan user_plg.
    public function findByUserPlg(string $userPlg): ?array
    {
        $sql = "SELECT
                    user_plg,
                    sandi,
                    nik,
                    nm_lngkp,
                    no_hp,
                    almt_lngkp,
                    ft_ktp,
                    ft_sim_a
                FROM t_penyewa
                WHERE user_plg = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query pencarian penyewa gagal disiapkan.'
            );
        }

        $stmt->bind_param('s', $userPlg);

        if (!$stmt->execute()) {
            $stmt->close();

            throw new RuntimeException(
                'Data penyewa gagal ditemukan.'
            );
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return $row ?: null;
    }

    // Menambahkan data penyewa baru.
    public function create(array $data): bool
    {
        $sql = "INSERT INTO t_penyewa (
                    user_plg,
                    sandi,
                    nik,
                    nm_lngkp,
                    no_hp,
                    almt_lngkp,
                    ft_ktp,
                    ft_sim_a
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query tambah penyewa gagal disiapkan.'
            );
        }

        $stmt->bind_param(
            'ssssssss',
            $data['user_plg'],
            $data['sandi'],
            $data['nik'],
            $data['nm_lngkp'],
            $data['no_hp'],
            $data['almt_lngkp'],
            $data['ft_ktp'],
            $data['ft_sim_a']
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Mengubah data penyewa.
    // Password hanya diubah jika sandi baru diberikan.
    public function update(
        string $userPlg,
        array $data
    ): bool {

        if (!empty($data['sandi'])) {

            $sql = "UPDATE t_penyewa SET
                        sandi = ?,
                        nik = ?,
                        nm_lngkp = ?,
                        no_hp = ?,
                        almt_lngkp = ?,
                        ft_ktp = ?,
                        ft_sim_a = ?
                    WHERE user_plg = ?";

            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new RuntimeException(
                    'Query ubah penyewa gagal disiapkan.'
                );
            }

            $stmt->bind_param(
                'ssssssss',
                $data['sandi'],
                $data['nik'],
                $data['nm_lngkp'],
                $data['no_hp'],
                $data['almt_lngkp'],
                $data['ft_ktp'],
                $data['ft_sim_a'],
                $userPlg
            );

        } else {

            $sql = "UPDATE t_penyewa SET
                        nik = ?,
                        nm_lngkp = ?,
                        no_hp = ?,
                        almt_lngkp = ?,
                        ft_ktp = ?,
                        ft_sim_a = ?
                    WHERE user_plg = ?";

            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new RuntimeException(
                    'Query ubah penyewa gagal disiapkan.'
                );
            }

            $stmt->bind_param(
                'sssssss',
                $data['nik'],
                $data['nm_lngkp'],
                $data['no_hp'],
                $data['almt_lngkp'],
                $data['ft_ktp'],
                $data['ft_sim_a'],
                $userPlg
            );
        }

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Menghapus data penyewa berdasarkan user_plg.
    public function delete(string $userPlg): bool
    {
        $sql = "DELETE FROM t_penyewa
                WHERE user_plg = ?";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'Query hapus penyewa gagal disiapkan.'
            );
        }

        $stmt->bind_param('s', $userPlg);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }
}
