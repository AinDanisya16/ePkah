<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/navbar.php'; // if you have your navbar reusable
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Info Kitar Semula</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">


            <div class="container my-5">

                <h1 class="mb-4">Kepentingan Kitar Semula</h1>

                <div class="mb-5">
                    <p>Kitar semula memainkan peranan penting dalam usaha memelihara alam sekitar dan mengurangkan
                        pencemaran. Antara kepentingannya:</p>
                    <ul>
                        <li>Mengurangkan jumlah sisa pepejal di tapak pelupusan sampah</li>
                        <li>Menjimatkan sumber semula jadi seperti kayu, air, dan mineral</li>
                        <li>Mengurangkan pencemaran udara, air, dan tanah</li>
                        <li>Menghasilkan tenaga melalui proses kitar semula bahan tertentu</li>
                        <li>Menyumbang kepada ekonomi melalui industri barangan kitar semula</li>
                    </ul>
                </div>

                <h2 class="mb-3">Harga Terkini Barang Kitar Semula (RM/kg)</h2>

                <table class="table table-bordered table-striped">
                    <thead class="table-success">
                        <tr>
                            <th>Jenis Barang</th>
                            <th>Harga (RM/kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kertas Surat Khabar</td>
                            <td>0.30</td>
                        </tr>
                        <tr>
                            <td>Tin Aluminium</td>
                            <td>4.50</td>
                        </tr>
                        <tr>
                            <td>Plastik Botol (PET)</td>
                            <td>1.20</td>
                        </tr>
                        <tr>
                            <td>Kotak</td>
                            <td>0.50</td>
                        </tr>
                        <tr>
                            <td>Kaca</td>
                            <td>0.10</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-muted">*Harga mungkin berbeza mengikut lokasi pusat kitar semula.</p>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Program Komuniti Amalan Hijau Kelantan (PKAH)</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>