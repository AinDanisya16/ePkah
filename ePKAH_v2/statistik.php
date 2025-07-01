<!DOCTYPE html>
<html>

<head>
    <title>📊 Statistik</title>
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
            <h2>📈 Statistik 🌿</h2>

            <!-- Filter Form -->
            <div class="filter-form">
                <form method="get">
                    <select name="kategori">
                        <option value="">Pilih Kategori</option>
                        <option value="UCO" <?= $kategori_filter == 'UCO' ? 'selected' : ''; ?>>UCO</option>
                        <option value="3R" <?= $kategori_filter == '3R' ? 'selected' : ''; ?>>3R</option>
                        <option value="E-waste" <?= $kategori_filter == 'E-waste' ? 'selected' : ''; ?>>E-waste</option>
                    </select>
                    <input type="number" name="berat" placeholder="Min Berat (kg)"
                        value="<?= htmlspecialchars($berat_filter); ?>">
                    <input type="number" name="nilai" placeholder="Min Nilai (RM)"
                        value="<?= htmlspecialchars($nilai_filter); ?>">
                    <input type="date" name="tarikh" value="<?= htmlspecialchars($tarikh_filter); ?>">
                    <button type="submit">🔍 Cari</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Kategori</th>
                        <th>Berat (kg)</th>
                        <th>Nilai (RM)</th>
                        <th>Tarikh Kutipan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_berat = 0;
                    $total_nilai = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tarikh = date("d/m/Y", strtotime($row['tarikh_kutipan']));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                            echo "<td>" . number_format($row['berat'], 2) . "</td>";
                            echo "<td>RM " . number_format($row['nilai'], 2) . "</td>";
                            echo "<td>$tarikh</td>";
                            echo "</tr>";

                            $total_berat += $row['berat'];
                            $total_nilai += $row['nilai'];
                        }

                        // Jumlah keseluruhan
                        echo "<tr class='total-row'>";
                        echo "<td colspan='2'>🔢 Jumlah Keseluruhan</td>";
                        echo "<td>" . number_format($total_berat, 2) . "</td>";
                        echo "<td>RM " . number_format($total_nilai, 2) . "</td>";
                        echo "<td>-</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='5'>❗ Tiada data kutipan.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>




</body>

</html>