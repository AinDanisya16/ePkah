<?php
session_start();
include 'includes/navbar.php';
$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Semak peranan admin
if (!isset($_SESSION['peranan']) || $_SESSION['peranan'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

// Ambil nilai filter dari borang (jika ada)
$jajahan_daerah_filter = isset($_POST['jajahan_daerah']) ? $_POST['jajahan_daerah'] : '';
$jenis_filter = isset($_POST['jenis']) ? $_POST['jenis'] : '';
$status_filter = isset($_POST['status']) ? $_POST['status'] : '';

// Bangunkan SQL query berdasarkan filter
$sql = "SELECT 
            p.id, 
            p.kategori, 
            p.jenis, 
            p.alamat, 
            p.poskod, 
            p.jajahan_daerah, 
            p.negeri, 
            p.gambar, 
            p.nama_pelajar, 
            p.nama_sekolah, 
            p.kelas, 
            p.cadangan_tarikh_kutipan, 
            p.tarikh_penghantaran, 
            p.status_kutipan, 
            u.nama, 
            p.no_telefon_untuk_dihubungi
        FROM penghantaran p
        JOIN users u ON p.id = u.id
        WHERE p.status_penghantaran = 'dalam semakan'";

if ($jajahan_daerah_filter) {
    $sql .= " AND p.jajahan_daerah = '" . $conn->real_escape_string($jajahan_daerah_filter) . "'";
}

if ($jenis_filter) {
    $sql .= " AND p.jenis = '" . $conn->real_escape_string($jenis_filter) . "'";
}

if ($status_filter) {
    $sql .= " AND p.status_kutipan = '" . $conn->real_escape_string($status_filter) . "'";
}

$sql .= " ORDER BY p.id DESC";
$result = $conn->query($sql);

// Senarai vendor untuk dropdown
$vendors = [];
$vendorQuery = $conn->query("SELECT id, nama FROM users WHERE peranan = 'vendor'");
while ($v = $vendorQuery->fetch_assoc()) {
    $vendors[] = $v;
}

// Senarai pilihan untuk filter
$jajahanQuery = $conn->query("SELECT DISTINCT jajahan_daerah FROM penghantaran WHERE jajahan_daerah != '' AND jajahan_daerah IS NOT NULL");
$jenisQuery = $conn->query("SELECT DISTINCT jenis FROM penghantaran");
$statusQuery = $conn->query("SELECT DISTINCT status_kutipan FROM penghantaran");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Senarai Penghantaran</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <h2>Senarai Penghantaran Pengguna (Menunggu Semakan)</h2>

            <!-- Filter Form -->
            <form method="post" action="">
                <div style="display: flex; justify-content: center; gap: 15px;">
                    <select name="jajahan_daerah">
                        <option value="">Pilih Jajahan/Daerah</option>
                        <?php while ($row = $jajahanQuery->fetch_assoc()) { ?>
                            <option value="<?= $row['jajahan_daerah'] ?>" <?= $row['jajahan_daerah'] == $jajahan_daerah_filter ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['jajahan_daerah']) ?>
                            </option>
                        <?php } ?>
                    </select>

                    <select name="jenis">
                        <option value="">Pilih Jenis</option>
                        <?php while ($row = $jenisQuery->fetch_assoc()) { ?>
                            <option value="<?= $row['jenis'] ?>" <?= $row['jenis'] == $jenis_filter ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['jenis']) ?>
                            </option>
                        <?php } ?>
                    </select>

                    <select name="status">
                        <option value="">Pilih Status</option>
                        <?php while ($row = $statusQuery->fetch_assoc()) { ?>
                            <option value="<?= $row['status_kutipan'] ?>" <?= $row['status_kutipan'] == $status_filter ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['status_kutipan']) ?>
                            </option>
                        <?php } ?>
                    </select>

                    <button type="submit"  class="nav-btn w-50"> Cari </button>
                </div>
            </form>

            <!-- Data Table -->
            <table class="table table-striped">
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Alamat</th>
                    <th>Poskod</th>
                    <th>Jajahan/Daerah</th>
                    <th>Tarikh Hantar</th>
                    <th>Status Kutipan</th>
                    <th>Assign Vendor</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td><?= htmlspecialchars($row['jenis']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td><?= htmlspecialchars($row['poskod']) ?></td>
                        <td><?= htmlspecialchars($row['jajahan_daerah']) ?></td>
                        <td><?= htmlspecialchars($row['tarikh_penghantaran']) ?></td>
                        <td><?= htmlspecialchars($row['status_kutipan']) ?></td>
                        <td>
                            <form action="admin_assign_vendor.php" method="post">
                                <input type="hidden" name="penghantaran_id" value="<?= $row['id'] ?>" />
                                <select name="vendor_id">
                                    <option value="">Pilih Vendor</option>
                                    <?php foreach ($vendors as $vendor) { ?>
                                        <option value="<?= $vendor['id'] ?>"><?= htmlspecialchars($vendor['nama']) ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit"
                                    style="background-color: #ff9800; color: white; border: none; border-radius: 4px; padding: 6px 12px;">
                                    Pilih
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>