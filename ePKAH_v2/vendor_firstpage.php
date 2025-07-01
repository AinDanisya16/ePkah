<?php
session_start();
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Statistik PKAH</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">

            <div class="row g-4">
                <!-- Summary Cards -->
                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Penghantaran Belum Dipungut</h5>
                            <h3>5</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Kutipan Selesai</h5>
                            <h3>20</h3>
                        </div>
                    </div>
                </div>

                <div class="container my-5">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>


</html>