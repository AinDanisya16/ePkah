<?php
$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sanitize helper
function clean($data, $conn)
{
    return mysqli_real_escape_string($conn, trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get form data
    $peranan = clean($_POST['peranan'], $conn);
    $nama = clean($_POST['nama'], $conn);
    $id_kakitangan = isset($_POST['id_kakitangan']) ? clean($_POST['id_kakitangan'], $conn) : NULL;
    $email = clean($_POST['email'], $conn);
    $telefon = clean($_POST['telefon'], $conn);
    $alamat = clean($_POST['alamat'], $conn);
    $poskod = clean($_POST['poskod'], $conn);
    $jajahan = clean($_POST['jajahan'], $conn);
    $negeri = clean($_POST['negeri'], $conn);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // vendor fields
    $nama_syarikat = isset($_POST['nama_syarikat']) ? clean($_POST['nama_syarikat'], $conn) : NULL;
    $no_syarikat = isset($_POST['no_syarikat']) ? clean($_POST['no_syarikat'], $conn) : NULL;
    $lokasi_kutipan = isset($_POST['lokasi_kutipan']) ?  json_encode($_POST['lokasi_kutipan']) : NULL;
    $jenis_barang = isset($_POST['jenis_barang']) ? json_encode($_POST['jenis_barang']) : NULL;

    // Generate new ID based on peranan
    switch ($peranan) {
        case 'admin':
            $prefix = 'A';
            break;
        case 'pengguna':
            $prefix = 'P';
            break;
        case 'vendor':
            $prefix = 'V';
            break;
        case 'sekolah/agensi':
            $prefix = 'S';
            break;
        default:
            $prefix = 'X';
    }

    // Find latest number
    $sql = "SELECT id FROM users WHERE id LIKE '$prefix%' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastIdNum = intval(substr($row['id'], 1)); // remove prefix and convert
        $newIdNum = $lastIdNum + 1;
    } else {
        $newIdNum = 1;
    }

    // format id (e.g. A001, P002)
    $newId = $prefix . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO users (id, peranan, nama, id_kakitangan, email, telefon, alamat, poskod, jajahan, negeri, password, nama_syarikat, no_syarikat, lokasi_kutipan, jenis_barang)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssssssssssss",
        $newId,
        $peranan,
        $nama,
        $id_kakitangan,
        $email,
        $telefon,
        $alamat,
        $poskod,
        $jajahan,
        $negeri,
        $password,
        $nama_syarikat,
        $no_syarikat,
        $lokasi_kutipan,
        $jenis_barang
    );

    if ($stmt->execute()) {
        // Success modal with redirect
        echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Pendaftaran Berjaya</title>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
        <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js'></script>
    </head>
    <body>

    <!-- Modal -->
    <div class='modal fade' id='successModal' tabindex='-1' role='dialog' aria-labelledby='successModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='successModalLabel'>Pendaftaran Berjaya</h5>
          </div>
          <div class='modal-body'>
            Tahniah, pendaftaran anda berjaya.<br>
            <strong>ID anda: $newId</strong><br>
            Anda akan dialihkan ke halaman log masuk sebentar lagi.
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-primary' onclick='window.location=\"index.php\"'>Pergi ke Log Masuk</button>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Show the modal immediately
    $(document).ready(function(){
        $('#successModal').modal('show');

        // Auto redirect after 5 seconds
        setTimeout(function(){
            window.location.href = 'index.php';
        }, 5000);
    });
    </script>

    </body>
    </html>
    ";
    } else {
        echo "Ralat: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna Baru</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="script.js"></script>
</head>

<body>
    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <img src="logo_epkah.png" alt="Logo ePKAH" class="logo">
            <h2>Daftar Akaun e-PKAH</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label>Peranan:</label>
                <select name="peranan" required onchange="toggleFields()">
                    <option value="">--Pilih Peranan--</option>
                    <option value="pengguna">Pengguna</option>
                    <option value="sekolah/agensi">Sekolah/Agensi</option>
                    <option value="vendor">Vendor</option>
                    <option value="admin">Admin</option>
                </select>

                <div style="display:none;">
                    <label>ID Pengguna:</label>
                    <input type="text" id="generated-id" name="id_dummy" readonly>
                </div>

                <label>Nama:</label>
                <input type="text" name="nama" required>

                <div id="admin-field" style="display:none;">
                    <label>No ID Kakitangan:</label>
                    <input type="text" name="id_kakitangan">
                </div>

                <label>Email:</label>
                <input type="email" name="email" required>

                <label>No Telefon:</label>
                <input type="text" name="telefon" required>

                <label>Alamat:</label>
                <input type="text" name="alamat" required>

                <label>Poskod:</label>
                <input type="text" name="poskod" required>

                <label>Jajahan/Daerah:</label>
                <select name="jajahan" required>
                    <option value="">--Pilih Jajahan--</option>
                    <option value="Bachok">Bachok</option>
                    <option value="Gua Musang">Gua Musang</option>
                    <option value="Jeli">Jeli</option>
                    <option value="Kota Bharu">Kota Bharu</option>
                    <option value="Kuala Krai">Kuala Krai</option>
                    <option value="Machang">Machang</option>
                    <option value="Pasir Mas">Pasir Mas</option>
                    <option value="Pasir Puteh">Pasir Puteh</option>
                    <option value="Tanah Merah">Tanah Merah</option>
                    <option value="Tumpat">Tumpat</option>
                </select>

                <label>Negeri:</label>
                <select name="negeri" required>
                    <option value="Kelantan">Kelantan</option>
                </select>

                <label>Katalaluan:</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="passwordField" required
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Mesti ada sekurang-kurangnya 8 aksara, huruf besar, huruf kecil, nombor & simbol"
                        style="width: 100%; padding-right: 40px;">

                </div>

                <div id="vendor-fields" style="display:none;">
                    <label>Nama Syarikat:</label>
                    <input type="text" name="nama_syarikat">

                    <label>No Syarikat:</label>
                    <input type="text" name="no_syarikat">

                    <label>Lokasi Pengumpulan:</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Kota Bharu"> Kota Bharu</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Bachok"> Bachok</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Gua Musang"> Gua Musang</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Jeli"> Jeli</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Kuala Krai"> Kuala Krai</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Machang"> Machang</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Pasir Mas"> Pasir Mas</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Pasir Puteh"> Pasir Puteh</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Tanah Merah"> Tanah Merah</label>
                        <label><input type="checkbox" name="lokasi_kutipan[]" value="Tumpat"> Tumpat</label>
                    </div>

                    <div class="checkbox-group">
                        <label>Jenis Barang:</label>
                        <label><input type="checkbox" name="jenis_barang[]" value="UCO"> Minyak Masak Terpakai
                            (UCO)</label>
                        <label><input type="checkbox" name="jenis_barang[]" value="e-waste"> E-Waste</label>
                        <label><input type="checkbox" name="jenis_barang[]" value="3R"> 3R</label>
                    </div>
                </div>

                <div class="terms-box" id="default-terms">
                    <strong>Terma & Syarat:</strong>
                    <ul>
                        <li>Barang yang dikutip perlu berada dalam keadaan bersih dan telah diasingkan mengikut kategori
                            kitar semula.</li>
                        <li>Jika barang tidak memenuhi kriteria kebersihan dan pengasingan, pihak kami berhak untuk
                            tidak mengambil barang tersebut bagi memastikan proses kitar semula berjalan dengan lancar
                            dan efektif.</li>
                        <li>Hasil jualan sedekah akan disumbangkan kepada organisasi kebajikan seperti Masjid atau badan
                            amal lain yang berkaitan.</li>
                    </ul>
                </div>

                <div class="terms-box" id="sekolah/agensi-terms">
                    <strong>Terma & Syarat:</strong>
                    <ul>
                        <li>Barang yang dikutip perlu berada dalam keadaan bersih dan telah diasingkan mengikut kategori
                            kitar semula.</li>
                        <li>Jika barang tidak memenuhi kriteria kebersihan dan pengasingan, pihak kami berhak untuk
                            tidak mengambil barang tersebut bagi memastikan proses kitar semula berjalan dengan lancar
                            dan efektif.</li>
                    </ul>
                </div>

                <div class="terms-box" id="vendor-terms" style="display:none;">
                    <strong>Terma & Syarat Vendor:</strong>
                    <ul>
                        <li>Kutipan perlu dibuat mengikut maklumat lesen dan lokasi yang telah diberikan semasa
                            pendaftaran.</li>
                        <li>Vendor bertanggungjawab memastikan proses kutipan berjalan mengikut jadual dan mematuhi
                            garis panduan agensi berkaitan.</li>
                    </ul>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input me-2" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        Saya setuju dengan <a href="#">Terma dan Syarat</a>
                    </label>
                </div>


                <button type="submit" class="nav-btn w-100">Daftar</button>
            </form>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Program Komuniti Amalan Hijau Kelantan (PKAH)</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>