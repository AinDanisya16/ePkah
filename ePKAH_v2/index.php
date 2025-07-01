<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefon = preg_replace('/[^0-9]/', '', $_POST['telefon']); // Hanya nombor sahaja
    $password = $_POST['password'];

    // Cari pengguna ikut no telefon
    $stmt = $conn->prepare("SELECT * FROM users WHERE telefon = ?");
    $stmt->bind_param("s", $telefon);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            //if ($user['status'] == 'approved') {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['peranan'] = strtolower($user['peranan']);

            if ($_SESSION['peranan'] === 'sekolah/agensi') {
                $_SESSION['nama_sekolah'] = $user['nama'];
            }

            $peranan = $_SESSION['peranan'];

            if ($peranan == 'admin') {
                header("Location: admin_firstpage.php");
                exit;
            } elseif ($peranan == 'vendor') {
                header("Location: vendor_firstpage.php");
                exit;
            } elseif ($peranan == 'pengguna') {
                header("Location: recycle_info.php");
                exit;
            } elseif ($peranan == 'sekolah/agensi') {
                header("Location: sekolah_dashboard.php");
                exit;
            } else {
                $error = "Peranan tidak dikenali.";
            }
            //} else {
            //  $error = "Akaun anda belum diluluskan.";
            //}
        } else {
            $error = "Katalaluan salah.";
        }
    } else {
        $error = "No telefon tidak dijumpai.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Log Masuk e-PKAH</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <img src="logo_epkah.png" alt="Logo ePKAH" class="logo">
            <div class="login-box">
                <h2>Log Masuk Pengguna</h2>

                <?php if ($error != "")
                    echo "<div class='error-msg'>$error</div>"; ?>

                <form method="POST" action="">
                    <input type="text" name="telefon" placeholder="No Telefon" required>
                    <input type="password" name="password" placeholder="Katalaluan" required>
                    <button type="submit" class="nav-btn w-100">Log Masuk</button>
                    <br>
                    <div class="d-flex justify-content-between mb-3">
                        <a href="signup.php">Daftar Akaun Baru</a>
                        <a href="forgot_password.php">Lupa Kata Laluan?</a>
                    </div>

                </form>


            </div>

        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Program Komuniti Amalan Hijau Kelantan (PKAH)</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>