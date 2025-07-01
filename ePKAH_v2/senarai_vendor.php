<?php
session_start();
include 'includes/navbar.php';
$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Semak kalau bukan admin
if (!isset($_SESSION['peranan']) || $_SESSION['peranan'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

// Ambil nilai filter jika ada
$lokasi_kutipan_filter = isset($_POST['lokasi_kutipan']) ? $_POST['lokasi_kutipan'] : '';
$jenis_barang_filter = isset($_POST['jenis_barang']) ? $_POST['jenis_barang'] : '';

// Dapatkan lokasi kutipan yang unik dan tidak kosong dari database
$lokasi_sql = "SELECT DISTINCT lokasi_kutipan FROM users WHERE peranan = 'vendor' AND lokasi_kutipan IS NOT NULL AND lokasi_kutipan != '' ORDER BY lokasi_kutipan";
$lokasi_result = $conn->query($lokasi_sql);

// Membina SQL berdasarkan filter
$sql = "SELECT id, nama_syarikat, no_syarikat, alamat, poskod, negeri, lokasi_kutipan, jenis_barang FROM users WHERE peranan = 'vendor'";

if ($lokasi_kutipan_filter || $jenis_barang_filter) {
    $sql .= " AND 1=1";
    if ($lokasi_kutipan_filter) {
        $sql .= " AND lokasi_kutipan LIKE '%" . $conn->real_escape_string($lokasi_kutipan_filter) . "%'";
    }
    if ($jenis_barang_filter) {
        $sql .= " AND jenis_barang LIKE '%" . $conn->real_escape_string($jenis_barang_filter) . "%'";
    }
}

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Senarai Vendor Berdaftar</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">

            <h2>🌿 Senarai Vendor Berdaftar e-PKAH 🌿</h2>

            <div class="filter-container">
                <form method="POST" action="">
                    <select name="lokasi_kutipan">
                        <option value="">Pilih Lokasi Kutipan</option>
                        <?php while ($lokasi_row = $lokasi_result->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($lokasi_row['lokasi_kutipan']) ?>"
                                <?= $lokasi_kutipan_filter == $lokasi_row['lokasi_kutipan'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($lokasi_row['lokasi_kutipan']) ?>
                            </option>
                        <?php } ?>
                    </select>
                    <select name="jenis_barang">
                        <option value="">Pilih Jenis Barang Dikutip</option>
                        <option value="Minyak Masak Terpakai (UCO)" <?= $jenis_barang_filter == 'Minyak Masak Terpakai (UCO)' ? 'selected' : ''; ?>>Minyak Masak Terpakai (UCO)</option>
                        <option value="Barangan Kitar Semula (3R)" <?= $jenis_barang_filter == 'Barangan Kitar Semula (3R)' ? 'selected' : ''; ?>>Barangan Kitar Semula (3R)</option>
                        <option value="E-waste" <?= $jenis_barang_filter == 'E-waste' ? 'selected' : ''; ?>>E-waste
                        </option>
                    </select>
                    <button type="submit" class="nav-btn">Tapis</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Syarikat</th>
                        <th>No. Syarikat</th>
                        <th>Alamat</th>
                        <th>Poskod</th>
                        <th>Negeri</th>
                        <th>Lokasi Kutipan</th>
                        <th>Jenis Barang Dikutip</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nama_syarikat']) ?></td>
                            <td><?= htmlspecialchars($row['no_syarikat']) ?></td>
                            <td><?= htmlspecialchars($row['alamat']) ?></td>
                            <td><?= htmlspecialchars($row['poskod']) ?></td>
                            <td><?= htmlspecialchars($row['negeri']) ?></td>
                            <td><?php 
                                // Decode JSON and display as comma-separated string
                                if (!empty($row['lokasi_kutipan'])) {
                                    $lokasi_array = json_decode($row['lokasi_kutipan'], true);
                                    if (is_array($lokasi_array)) {
                                        echo htmlspecialchars(implode(', ', $lokasi_array));
                                    } else {
                                        echo htmlspecialchars($row['lokasi_kutipan']);
                                    }
                                } else {
                                    echo '-';
                                }
                            ?></td>
                            <td><?php 
                                // Decode JSON and display as comma-separated string
                                if (!empty($row['jenis_barang'])) {
                                    $jenis_array = json_decode($row['jenis_barang'], true);
                                    if (is_array($jenis_array)) {
                                        echo htmlspecialchars(implode(', ', $jenis_array));
                                    } else {
                                        echo htmlspecialchars($row['jenis_barang']);
                                    }
                                } else {
                                    echo '-';
                                }
                            ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>