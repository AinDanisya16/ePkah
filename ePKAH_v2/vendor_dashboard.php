

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <style>
        body {
            font-family: Consolas, monospace;
            padding: 30px;
            background-color: #f0fff0;
            font-size: 18px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
            font-size: 32px;
        }

        a {
            display: inline-block;
            margin: 15px 0;
            padding: 12px 25px;
            background-color: #43a047;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 20px;
            text-align: center;
        }

        a:hover {
            background-color: #2e7d32;
        }

        .dashboard-container {
            text-align: center;
        }

        .logo {
            display: block;
            margin: 0 auto 16px;
            width: 120px; /* Saiz logo lebih besar */
            height: 100px;
        }

        .header {
            height: 100px; /* Set height to 100px */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="logo_epkah.png" alt="Logo ePKAH" class="logo">
    </div>

    <div class="dashboard-container">
        <h2>Selamat Datang Vendor: <?= $_SESSION['nama']; ?></h2>

        <a href="vendor_penghantaran.php">📦 Senarai Penghantaran Masuk</a><br>
        <a href="laporan_data_kutipan.php">📊 Laporan Data Kutipan</a><br>        
        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>


