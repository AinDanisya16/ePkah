<?php
session_start();
include 'includes/navbar.php';

$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan admin
if (!isset($_SESSION['peranan']) || $_SESSION['peranan'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

// Handle search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build SQL query with search
$sql = "SELECT id, nama, telefon, peranan, alamat, jajahan
        FROM users
        WHERE peranan = 'pengguna'";

if (!empty($search)) {
    $sql .= " AND (nama LIKE '%" . $conn->real_escape_string($search) . "%' 
              OR telefon LIKE '%" . $conn->real_escape_string($search) . "%')";
}

$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Pengguna</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <h2>♻️ Senarai Pengguna e-PKAH ♻️</h2>
            
            <!-- Search Form -->
            <div class="search-container mb-4">
                <form method="GET" action="" class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <input type="text" 
                               name="search" 
                               value="<?= htmlspecialchars($search) ?>" 
                               placeholder="Cari mengikut nama atau nombor telefon..." 
                               class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            🔍 Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="senarai_pengguna.php" class="btn btn-secondary w-100">
                            🔄 Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Search Results Info -->
            <?php if (!empty($search)): ?>
                <div class="alert alert-info text-center mb-3">
                    <strong>Hasil Carian:</strong> 
                    <?= $result->num_rows ?> pengguna dijumpai untuk "<?= htmlspecialchars($search) ?>"
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Telefon</th>
                        <th>Alamat</th>
                        <th>Jajahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['telefon']) ?></td>
                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                <td><?= htmlspecialchars($row['jajahan']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <?php if (!empty($search)): ?>
                                    Tiada pengguna dijumpai untuk "<?= htmlspecialchars($search) ?>".
                                <?php else: ?>
                                    Tiada rekod pengguna.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php $conn->close(); ?>

</body>

</html>