<?php
session_start();
include 'includes/navbar.php';
?>


<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kitar Semula - epkah</title>
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
            <h1>♻️ Program Kitar Semula di Kota Bharu</h1>

            <!-- Program 1: Kempen Kitar Semula -->
            <div class="program-card">
                <div class="program-title">Kempen Kitar Semula Kota Bharu 💚</div>
                <div class="program-details">
                    Ayuh, mari kita sama-sama menyertai Kempen Kitar Semula Kota Bharu! Dalam program ini, kita akan
                    mengumpulkan barang-barang kitar semula seperti kertas, plastik, dan kaca untuk dikitar semula dan
                    dimanfaatkan kembali. 🗑️♻️
                </div>
                <div class="program-date">
                    🗓️ Tarikh: 15 Mei 2025 - 17 Mei 2025
                </div>
                <div class="emoji">🌿🌍</div>
            </div>

            <!-- Program 2: Pengumpulan Bahan Kitar Semula -->
            <div class="program-card">
                <div class="program-title">Pengumpulan Bahan Kitar Semula di Pasar Raya 🌱</div>
                <div class="program-details">
                    Kita akan mengadakan sesi pengumpulan bahan kitar semula di beberapa pasar raya sekitar Kota Bharu.
                    Bawa
                    barang-barang kitar semula kamu dan dapatkan hadiah menarik! 🎁♻️
                </div>
                <div class="program-date">
                    🗓️ Tarikh: 20 Mei 2025 - 22 Mei 2025
                </div>
                <div class="emoji">🛒🌿</div>
            </div>

            <!-- Program 3: Kerjasama dengan Komuniti -->
            <div class="program-card">
                <div class="program-title">Kerjasama Komuniti dalam Kitar Semula 🤝</div>
                <div class="program-details">
                    Bergabung dengan komuniti setempat untuk memperkenalkan cara-cara kitar semula yang lebih baik dan
                    meningkatkan kesedaran alam sekitar. Kami memerlukan sukarelawan untuk membantu! 🌱
                </div>
                <div class="program-date">
                    🗓️ Tarikh: 25 Mei 2025 - 27 Mei 2025
                </div>
                <div class="emoji">🤲🌍</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Program Komuniti Amalan Hijau Kelantan (PKAH)</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>