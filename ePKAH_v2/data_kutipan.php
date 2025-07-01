<?php
session_start();
include 'includes/navbar.php';

if (!isset($_SESSION['peranan']) || $_SESSION['peranan'] !== 'vendor') {
    echo "Akses ditolak!";
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "kelantanutiliti_epkah");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get penghantaran_id from GET or POST
$penghantaran_id = isset($_GET['penghantaran_id']) ? $_GET['penghantaran_id'] : (isset($_POST['penghantaran_id']) ? $_POST['penghantaran_id'] : null);
if (!$penghantaran_id) {
    echo "ID penghantaran tidak diberikan.";
    exit;
}

// Fetch penghantaran row
$penghantaran_sql = "SELECT * FROM penghantaran WHERE id = ?";
$stmt = $conn->prepare($penghantaran_sql);
$stmt->bind_param("i", $penghantaran_id);
$stmt->execute();
$penghantaran_result = $stmt->get_result();
$penghantaran = $penghantaran_result->fetch_assoc();
$stmt->close();

if (!$penghantaran) {
    echo "Penghantaran tidak dijumpai.";
    exit;
}

// Fetch user row
$user_sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("s", $penghantaran['id']);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "Pengguna tidak dijumpai.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>🌿 Tambah Data Kutipan Vendor</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <script>
        let kutipanList = [];

        function updateForm() {
            var kategori = document.getElementById('kategori').value;
            document.getElementById('uco-fields').style.display = (kategori === 'UCO') ? 'block' : 'none';
            document.getElementById('ewaste-fields').style.display = (kategori === 'E-Waste') ? 'block' : 'none';
            document.getElementById('3r-fields').style.display = (kategori === '3R') ? 'block' : 'none';
        }

        function update3RFields() {
            var item3R = document.getElementById('item_3r').value;
            document.getElementById('3r-weight-value').style.display = (item3R !== '') ? 'block' : 'none';
        }

        function tambahKutipan() {
            var kategori = document.getElementById('kategori').value;
            if (kategori === "") {
                alert("Sila pilih kategori.");
                return;
            }

            let data = { kategori: kategori };
            if (kategori === 'UCO') {
                data.berat = document.getElementsByName('berat_uco')[0].value;
                data.nilai = document.getElementsByName('nilai_uco')[0].value;
            } else if (kategori === '3R') {
                data.item = document.getElementsByName('item_3r')[0].value;
                data.berat = document.getElementsByName('berat_3r')[0].value;
                data.nilai = document.getElementsByName('nilai_3r')[0].value;
            } else if (kategori === 'E-Waste') {
                data.berat = document.getElementsByName('berat_ewaste')[0].value;
                data.nilai = document.getElementsByName('nilai_ewaste')[0].value;
            }

            kutipanList.push(data);
            renderKutipanList();
            document.getElementById('form-kutipan').reset();
            updateForm();
        }

        function renderKutipanList() {
            var html = "<ul>";
            kutipanList.forEach(function (item, index) {
                html += "<li>[" + item.kategori + "] " +
                    (item.item ? item.item + " - " : "") +
                    "Berat: " + item.berat + "kg, Nilai: RM" + item.nilai +
                    " <button onclick='padamKutipan(" + index + ")'>Padam</button></li>";
            });
            html += "</ul>";
            document.getElementById('senarai-kutipan').innerHTML = html;
        }

        function padamKutipan(index) {
            kutipanList.splice(index, 1);
            renderKutipanList();
        }

        function submitSemua() {
            if (kutipanList.length === 0) {
                alert("Tiada kutipan untuk dihantar.");
                return;
            }

            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'proses_data_kutipan.php'; // tukar ke proses simpan kutipan

            var penghantaran_id = document.createElement('input');
            penghantaran_id.type = 'hidden';
            penghantaran_id.name = 'id';
            penghantaran_id.value = <?= $penghantaran['id'] ?>;
            form.appendChild(penghantaran_id);

            kutipanList.forEach(function (item, index) {
                for (const key in item) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'kutipan_vendor[' + index + '][' + key + ']'; // nama array tukar jadi kutipan_vendor
                    input.value = item[key];
                    form.appendChild(input);
                }
            });

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>


    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">

            <h2> Tambah Data Kutipan Vendor</h2>

            <div class="info-box">
                📋 Sila tambah kutipan satu per satu, kemudian klik "🚛 Hantar Semua Kutipan".
            </div>

            <form id="form-kutipan" onsubmit="event.preventDefault(); tambahKutipan();">
                <div class="section">
                    <label>Nama Pengguna</label>
                    <input type="text" value="<?= htmlspecialchars($user['nama']) ?>" readonly>

                    <label>Alamat Penghantaran</label>
                    <input type="text" value="<?= htmlspecialchars($user['alamat']) ?>" readonly>

                    <label> Jajahan/Daerah</label>
                    <input type="text" value="<?= htmlspecialchars($user['jajahan']) ?>" readonly>

                    <label> No Telefon Untuk Dihubungi</label>
                    <input type="text" value="<?= htmlspecialchars($user['telefon']) ?>"
                        readonly>
                </div>

                <div class="section">
                    <label>Pilih Kategori Kutipan</label>
                    <select name="kategori" id="kategori" onchange="updateForm()" required>
                        <option value="">-- Sila Pilih Kategori --</option>
                        <option value="UCO">Minyak Masak Terpakai (UCO)</option>
                        <option value="3R">Barangan Kitar Semula (3R)</option>
                        <option value="E-Waste">Barang Elektrik & Elektronik (E-Waste)</option>
                    </select>
                </div>

                <div id="uco-fields" style="display:none;">
                    <label>Berat (kg)</label>
                    <input type="number" step="0.01" name="berat_uco">
                    <label>Nilai (RM)</label>
                    <input type="number" step="0.01" name="nilai_uco">
                </div>

                <div id="3r-fields" style="display:none;">
                    <label>Pilih Item 3R</label>
                    <select name="item_3r" id="item_3r" onchange="update3RFields()">
                        <option value="">-- Sila Pilih --</option>
                        <option value="Plastik">Plastik</option>
                        <option value="Kertas">Kertas</option>
                        <option value="Kotak">Kotak</option>
                        <option value="Tin_Aluminiun">Tin Aluminium</option>
                        <option value="Besi">Besi</option>
                    </select>

                    <div id="3r-weight-value" style="display:none;">
                        <label>Berat (kg)</label>
                        <input type="number" step="0.01" name="berat_3r">
                        <label>Nilai (RM)</label>
                        <input type="number" step="0.01" name="nilai_3r">
                    </div>
                </div>

                <div id="ewaste-fields" style="display:none;">
                    <label>Berat (kg)</label>
                    <input type="number" step="0.01" name="berat_ewaste">
                    <label>Nilai (RM)</label>
                    <input type="number" step="0.01" name="nilai_ewaste">
                </div>

                <button type="submit" class="nav-btn">Tambah Kutipan</button>
            </form>

            <div id="senarai-kutipan" style="margin-top: 25px;"></div>

            <button onclick="submitSemua()" class="nav-btn">Hantar Semua Kutipan</button>
        </div>

    </div>
</body>

</html>