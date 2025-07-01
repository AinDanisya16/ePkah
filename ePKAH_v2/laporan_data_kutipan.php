<?php
session_start();
include 'includes/navbar.php';

if (!isset($_SESSION['peranan']) || $_SESSION['peranan'] !== 'vendor') {
    echo "Akses ditolak!";
    exit;
}

$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$vendor_id = $_SESSION['id'];

// Ambil filter dari GET
$kategori_filter = $_GET['kategori'] ?? '';
$tarikh_mula = $_GET['tarikh_mula'] ?? '';
$tarikh_akhir = $_GET['tarikh_akhir'] ?? '';

// Query asas
$sql = "SELECT 
            u.nama AS nama_pengguna, 
            p.jajahan_daerah, 
            kv.kategori, 
            kv.item_3r AS jenis,  
            kv.berat_kg, 
            kv.nilai_rm, 
            p.tarikh_penghantaran AS tarikh_kutipan 
        FROM kutipan_vendor kv
        JOIN penghantaran p ON kv.penghantaran_id = p.id
        JOIN users u ON p.id = u.id
        WHERE p.vendor_id = ?";


$params = [$vendor_id];
$types = "i";

// Tambah filter kategori jika ada
if (!empty($kategori_filter)) {
    $sql .= " AND kv.kategori = ?";
    $types .= "s";
    $params[] = $kategori_filter;
}

// Tambah filter tarikh jika ada
if (!empty($tarikh_mula) && !empty($tarikh_akhir)) {
    $sql .= " AND kv.tarikh_kutipan BETWEEN ? AND ?";
    $types .= "ss";
    $params[] = $tarikh_mula;
    $params[] = $tarikh_akhir;
}

$sql .= " ORDER BY kv.id DESC"; // Urutan mengikut id terbaru

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kutipan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">

            <h2>📄 Laporan Data Kutipan Vendor</h2>

            <!-- Form Filter -->
            <form method="GET" class="filter">
                <label for="kategori">♻️ Kategori:</label>
                <select name="kategori" id="kategori">
                    <option value="">-- Semua --</option>
                    <option value="Minyak Masak Terpakai" <?= $kategori_filter == 'Minyak Masak Terpakai' ? 'selected' : '' ?>>Minyak Masak Terpakai</option>
                    <option value="E-Waste" <?= $kategori_filter == 'E-Waste' ? 'selected' : '' ?>>E-Waste</option>
                    <option value="Plastik" <?= $kategori_filter == 'Plastik' ? 'selected' : '' ?>>Plastik</option>
                    <option value="Besi/Tin" <?= $kategori_filter == 'Besi/Tin' ? 'selected' : '' ?>>Besi/Tin</option>
                    <option value="Aluminium" <?= $kategori_filter == 'Aluminium' ? 'selected' : '' ?>>Aluminium</option>
                    <option value="Kotak" <?= $kategori_filter == 'Kotak' ? 'selected' : '' ?>>Kotak</option>
                    <option value="Kertas" <?= $kategori_filter == 'Kertas' ? 'selected' : '' ?>>Kertas</option>
                </select>

                <label for="tarikh_mula">Tarikh Mula:</label>
                <input type="date" name="tarikh_mula" id="tarikh_mula" value="<?= htmlspecialchars($tarikh_mula) ?>">

                <label for="tarikh_akhir">Tarikh Akhir:</label>
                <input type="date" name="tarikh_akhir" id="tarikh_akhir" value="<?= htmlspecialchars($tarikh_akhir) ?>">
            
                <button type="submit" class="nav-btn">Tapis</button>
            </form>

            <!-- Tabel Laporan -->
            <table>
                <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Jajahan/Daerah</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Berat (KG)</th>
                    <th>Nilai (RM)</th>
                    <th>Tarikh Kutipan</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
                            <td><?= htmlspecialchars($row['jajahan_daerah']) ?></td>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= htmlspecialchars($row['jenis']) ?></td>
                            <td><?= number_format($row['berat']) ?></td>
                            <td>RM <?= number_format($row['nilai']) ?></td>
                            <td><?= htmlspecialchars($row['tarikh_kutipan']) ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tiada data kutipan untuk ditunjukkan berdasarkan filter yang diberikan.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
$conn->close();
?>