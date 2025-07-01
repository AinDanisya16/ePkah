<!DOCTYPE html>
<html>

<head>
    <title>Lupa Kata Laluan</title>
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
            <h2>Lupa Kata Laluan</h2>
            <form method="POST">
                <label>Masukkan Nama:</label>
                <input type="text" name="nama" required>
                <button type="submit">Hantar</button>
            </form>
        </div>
    </div>

</body>

</html>