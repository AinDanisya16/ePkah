<?php
session_start();
include 'includes/navbar.php';


if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id'];
require "db.php";
$query = "SELECT * FROM penghantaran WHERE id = '$id'";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Penghantaran Saya</title>
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
            <h2>🌿 Senarai Penghantaran Saya 🌿</h2>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Tarikh Hantar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis']) . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($row['tarikh_penghantaran'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status_penghantaran']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>Tiada penghantaran dijumpai.</td></tr>";
                    }
                    ?>
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