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
<div>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <div class="container my-5">
                <h1 class="text-center mb-4">Dashboard Statistik PKAH</h1>

                <!-- Ringkasan Statistik -->
                <div class="row text-center mb-4">
                    <div class="col-md-6">
                        <div class="card shadow p-3">
                            <h2>55</h2>
                            <p>Jumlah Vendor</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow p-3">
                            <h2>240</h2>
                            <p>Jumlah Pengguna</p>
                        </div>
                    </div>
                </div>

                <!-- Carta Sisa Terkumpul -->
                <div class="card p-4 shadow">
                    <h3 class="text-center">Carta Bilangan Sisa Terkumpul Mengikut Bulan (kg)</h3>
                    <canvas id="sisaChart" height="100"></canvas>
                </div>

            </div>

            <script>
                const ctx = document.getElementById('sisaChart').getContext('2d');
                const sisaChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'],
                        datasets: [
                            {
                                label: 'UCO',
                                data: [120, 95, 130, 160, 110, 180, 210, 230, 190, 150, 170, 200],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true
                            },
                            {
                                label: 'Kertas',
                                data: [300, 250, 310, 280, 260, 350, 390, 400, 370, 340, 330, 380],
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true
                            },
                            {
                                label: 'E-Waste',
                                data: [60, 55, 70, 65, 80, 90, 100, 95, 85, 80, 90, 110],
                                borderColor: 'rgba(255, 206, 86, 1)',
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah (kg)'
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>

    <?php
include 'includes/footer.php';
?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>


</html>