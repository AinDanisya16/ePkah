<?php
require 'db.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
} else {
    echo "Kod reset tidak sah.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "Kata laluan tidak sepadan!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE reset_code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ?, reset_code = NULL WHERE id = ?");
            $update->bind_param("si", $hashed, $user_id);
            $update->execute();

            echo "<p style='font-size: 18px;'>Kata laluan berjaya ditukar. <a href='index.php'>Log Masuk</a></p>";
        } else {
            echo "<p style='font-size: 18px;'>Kod tidak sah!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tetapkan Semula Kata Laluan</title>
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
            <h2>Tetapkan Kata Laluan Baharu</h2>
            <form method="post">
                <label>Kata Laluan Baru:</label>
                <input type="password" name="password" required>

                <label>Sahkan Kata Laluan:</label>
                <input type="password" name="confirm" required>

                <input type="submit" value="Reset Kata Laluan">
            </form>
        </div>
    </div>

</body>

</html>