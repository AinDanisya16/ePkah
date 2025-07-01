<?php
session_start();
include("db.php");

if (!isset($_SESSION['id'])) {
    die("❌ Sila log masuk terlebih dahulu untuk menghantar permintaan.");
}

// Ambil user_id dan peranan dari borang
$id = $_POST['id'] ?? $_SESSION['id'];
$peranan = $_POST['peranan'] ?? $_SESSION['peranan'] ?? 'pengguna';

// Ambil data dari borang
$kategori = $_POST['kategori'] ?? '';
$jenis = $_POST['jenis'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$poskod = $_POST['poskod'] ?? '';
$jajahan_daerah = $_POST['jajahan_daerah'] ?? '';
$negeri = $_POST['negeri'] ?? '';
$no_telefon = $_POST['no_telefon_untuk_dihubungi'] ?? '';
$nama_pelajar = $_POST['nama_pelajar'] ?? '';
$nama_sekolah = $_POST['nama_sekolah'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$cadangan_tarikh_kutipan = $_POST['cadangan_tarikh_kutipan'] ?? '';

// Semak input wajib
if (empty($kategori) || empty($jenis) || empty($alamat) || empty($poskod) || empty($jajahan_daerah) || empty($negeri)) {
    die("❌ Sila lengkapkan semua maklumat wajib.");
}

// Semak tarikh kutipan dalam tempoh 2 minggu
if (!empty($cadangan_tarikh_kutipan)) {
    $selected_date = new DateTime($cadangan_tarikh_kutipan);
    $today = new DateTime();
    $two_weeks_from_now = new DateTime();
    $two_weeks_from_now->add(new DateInterval('P14D')); // Add 14 days
    
    if ($selected_date < $today || $selected_date > $two_weeks_from_now) {
        die("❌ Tarikh kutipan mestilah dalam tempoh 2 minggu dari hari ini.");
    }
}

// Uruskan muat naik gambar
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$gambar = $_FILES["gambar"]["name"] ?? '';
if ($gambar) {
    $targetFile = $targetDir . basename($gambar);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        die("❌ Fail bukan gambar yang sah.");
    }

    if ($_FILES["gambar"]["size"] > 2000000) {
        die("❌ Gambar melebihi saiz maksimum 2MB.");
    }

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        die("❌ Hanya fail JPG, JPEG, PNG & GIF dibenarkan.");
    }

    if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
        die("❌ Maaf, berlaku ralat semasa muat naik gambar.");
    }
} else {
    $gambar = NULL;
}

// Masukkan data ke dalam jadual penghantaran
$stmt = $conn->prepare("INSERT INTO penghantaran 
(id, peranan_penghantar, kategori, jenis, alamat, poskod, jajahan_daerah, negeri, no_telefon_untuk_dihubungi, gambar, nama_pelajar, nama_sekolah, kelas, cadangan_tarikh_kutipan, tarikh_penghantaran) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

$stmt->bind_param("isssssssssssss", 
    $id, $peranan, $kategori, $jenis, $alamat, $poskod, $jajahan_daerah, $negeri, $no_telefon, $gambar, $nama_pelajar, $nama_sekolah, $kelas, $cadangan_tarikh_kutipan);

if ($stmt->execute()) {
    // ✅ Simpan log aktiviti
    $tindakan = ($peranan === 'sekolah/agensi') 
        ? "Sekolah/Agensi menghantar borang penghantaran kategori $kategori ($jenis)"
        : "Pengguna menghantar borang penghantaran kategori $kategori ($jenis)";

    $log_stmt = $conn->prepare("INSERT INTO aktiviti_log (id, peranan, tindakan) VALUES (?, ?, ?)");
    $log_stmt->bind_param("iss", $id, $peranan, $tindakan);
    $log_stmt->execute();
    $log_stmt->close();

    // Return success response for AJAX
    echo "success";
} else {
    echo "❌ Maaf, berlaku ralat: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
