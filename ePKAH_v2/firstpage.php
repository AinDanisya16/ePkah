<?php
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Program Komuniti Amalan Hijau Kelantan (PKAH)</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">

            <!-- Hero Section -->
            <div class="bg-success text-white text-center py-5">
                <h1 class="display-4">Program Komuniti Amalan Hijau Kelantan (PKAH)</h1>
                <p class="lead">Mendidik masyarakat mengamalkan kehidupan lestari dan penjagaan alam sekitar</p>
            </div>

            <!-- Program Overview -->
            <section class="container my-5">
                <h2 class="text-center mb-4">Tentang Program</h2>
                <p class="text-center">PKAH merupakan inisiatif kerajaan negeri Kelantan untuk mendidik komuniti agar
                    mengamalkan gaya hidup lestari dan bertanggungjawab terhadap alam sekitar. Program ini berteraskan
                    konsep <strong>ekonomi kitaran</strong> bagi mengurangkan sisa pembuangan dan memanfaatkan sumber
                    terpakai.</p>
            </section>

            <!-- Key Statistics Section -->
            <section class="bg-light py-5">
                <div class="container">
                    <h3 class="text-center mb-4">Pencapaian Program</h3>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h1 class="display-5">55</h1>
                            <p>Komuniti Terlibat</p>
                        </div>
                        <div class="col-md-4">
                            <h1 class="display-5">410 Tan</h1>
                            <p>Sampah Dikurangkan</p>
                        </div>
                        <div class="col-md-4">
                            <h1 class="display-5">RM</h1>
                            <p>Menjana Pendapatan Komuniti</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="text-center py-5">
                <div class="container">
                    <h2>Sertai Komuniti Hijau Hari Ini!</h2>
                    <p class="mb-4">Bersama kita amalkan kehidupan lestari demi kelestarian alam sekitar Kelantan.</p>
                    <a href="signup.php" class="btn btn-success btn-lg">Daftar Sekarang</a>
                </div>
            </section>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Program Komuniti Amalan Hijau Kelantan (PKAH)</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>