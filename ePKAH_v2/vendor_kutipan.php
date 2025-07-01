<?php
session_start();
include 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $kategori = $_POST['kategori'];
    $berat = $_POST['berat'];
    $nilai = $_POST['nilai'];

    $_SESSION['cart'][] = [
        'kategori' => $kategori,
        'berat' => $berat,
        'nilai' => $nilai
    ];
}

// Submit cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_cart'])) {
    $vendor_id = $_SESSION['vendor_id'];
    $nama_pengguna = $_SESSION['nama_pengguna'];

    foreach ($_SESSION['cart'] as $item) {
        $kategori = $item['kategori'];
        $berat = $item['berat'];
        $nilai = $item['nilai'];

        $stmt = $conn->prepare("INSERT INTO kutipan (vendor_id, nama_pengguna, kategori, berat, nilai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $vendor_id, $nama_pengguna, $kategori, $berat, $nilai);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['cart'] = []; // Kosongkan cart ✅
    $success = true; // Tunjuk message cute
}
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Data Kutipan</title>
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
            <h1>🌱 Data Kutipan Vendor 🌿</h1>

            <?php if (!empty($success)): ?>
                <div class="success-message">
                    ✅ Berjaya hantar kutipan! Terima kasih! 🥰
                </div>
            <?php endif; ?>

            <form method="post">
                <label for="kategori">Kategori Sisa:</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Minyak Masak Terpakai">Minyak Masak Terpakai</option>
                    <option value="E-Waste">E-Waste</option>
                    <option value="Plastik">Plastik</option>
                    <option value="Besi/Tin">Besi/Tin</option>
                    <option value="Tin Aluminium">Tin Aluminium</option>
                    <option value="Kotak">Kotak</option>
                    <option value="Kertas">Kertas</option>
                </select>

                <label for="berat">Berat (kg):</label>
                <input type="number" step="0.01" id="berat" name="berat" required>

                <label for="nilai">Nilai (RM):</label>
                <input type="number" step="0.01" id="nilai" name="nilai" required>

                <button type="submit" name="add_item" class="nav-btn" >Tambah ke Cart</button>
            </form>

            <?php if (!empty($_SESSION['cart'])): ?>
                <h2>🛒 Cart Semasa</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Berat (kg)</th>
                            <th>Nilai (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['kategori']) ?></td>
                                <td><?= htmlspecialchars($item['berat']) ?></td>
                                <td><?= htmlspecialchars($item['nilai']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <form method="post" style="text-align:center">
                    <button type="submit" name="submit_cart">Hantar Kutipan 📤</button>
                </form>
            <?php endif; ?>
        </div>
    </div>



</body>

</html>