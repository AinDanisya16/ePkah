<?php
// db.php
$host = "localhost";
$user = "kelantanutiliti_epkahuser";
$pass = "Br-2506-##-$";
$db   = "kelantanutiliti_epkah";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
