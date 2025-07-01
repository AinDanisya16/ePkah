<?php
session_start();
include 'includes/navbar.php';
// hantar_kitar_semula.php

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id'];
$peranan = $_SESSION['peranan'];
require "db.php";
?>

<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Borang Penghantaran Kitar Semula</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function updateDescription() {
            var kategori = document.getElementById("kategori").value;
            document.getElementById("desc-3r").style.display = kategori === "3R" ? "block" : "none";
            document.getElementById("desc-ewaste").style.display = kategori === "E-waste" ? "block" : "none";
        }

        // Set date restrictions for cadangan_tarikh_kutipan
        function setDateRestrictions() {
            const today = new Date();
            const twoWeeksFromNow = new Date();
            twoWeeksFromNow.setDate(today.getDate() + 14); // 2 weeks = 14 days
            
            // Format dates for input min/max attributes (YYYY-MM-DD)
            const todayFormatted = today.toISOString().split('T')[0];
            const twoWeeksFormatted = twoWeeksFromNow.toISOString().split('T')[0];
            
            const dateInput = document.getElementById('cadangan_tarikh_kutipan');
            dateInput.min = todayFormatted;
            dateInput.max = twoWeeksFormatted;
            
            // Set placeholder text
            dateInput.placeholder = `Pilih tarikh antara ${todayFormatted} hingga ${twoWeeksFormatted}`;
        }

        // Handle form submission with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            // Set date restrictions when page loads
            setDateRestrictions();
            
            const form = document.getElementById('penghantaranForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate date before submission
                const dateInput = document.getElementById('cadangan_tarikh_kutipan');
                const selectedDate = new Date(dateInput.value);
                const today = new Date();
                const twoWeeksFromNow = new Date();
                twoWeeksFromNow.setDate(today.getDate() + 14);
                
                if (selectedDate < today || selectedDate > twoWeeksFromNow) {
                    alert('Sila pilih tarikh dalam tempoh 2 minggu dari hari ini.');
                    return;
                }
                
                const formData = new FormData(form);
                
                fetch('proses_penghantaran.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes('success')) {
                        // Show success modal
                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();
                    } else {
                        // Show error message
                        alert('Ralat: ' + data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ralat semasa menghantar borang.');
                });
            });
        });
    </script>
</head>

<body>

    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <h2>💚 Borang Penghantaran Kitar Semula 🍃</h2>


            <form id="penghantaranForm" action="proses_penghantaran.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="peranan" value="<?php echo htmlspecialchars($peranan); ?>">

                <label>Kategori:</label>
                <select id="kategori" name="kategori" required onchange="updateDescription()">
                    <option value="">--Pilih Kategori--</option>
                    <option value="UCO">Minyak Masak Terpakai (UCO)</option>
                    <option value="3R">Barangan Kitar Semula (3R)</option>
                    <option value="E-waste">Barang Elektrik & Elektronik (E-waste)</option>
                </select>

                <div id="desc-3r">
                    <strong>Penerangan Kitar Semula (3R):</strong>
                    <p>Barang kitar semula yang diterima ialah plastik, kotak, kertas, tin aluminium, dan besi.</p>
                </div>

                <div id="desc-ewaste">
                    <strong>Penerangan Kitar Semula (E-waste):</strong>
                    <p>Barang yang berkaitan elektrik & elektronik, contohnya : powerbank, wayar, telefon bimbit, TV,
                        aircond, cerek, dan lain-lain. 🔌📱💻</p>
                </div>

                <label>Jenis:</label>
                <select name="jenis" required>
                    <option value="">--Pilih Jenis--</option>
                    <option value="sedekah">Sedekah</option>
                    <option value="jual">Jual</option>
                </select>

                <label>Alamat:</label>
                <input type="text" name="alamat" required>

                <label>Poskod:</label>
                <input type="text" name="poskod" required>

                <label>Jajahan/Daerah:</label>
                <select name="jajahan_daerah" required>
                    <option value="">--Pilih Jajahan/Daerah--</option>
                    <option>Bachok</option>
                    <option>Gua Musang</option>
                    <option>Jeli</option>
                    <option>Kota Bharu</option>
                    <option>Kuala Krai</option>
                    <option>Machang</option>
                    <option>Pasir Mas</option>
                    <option>Pasir Puteh</option>
                    <option>Tanah Merah</option>
                    <option>Tumpat</option>
                </select>

                <label>Negeri:</label>
                <select name="negeri" required>
                    <option>Kelantan</option>
                </select>

                <label>No Telefon Untuk Dihubungi:</label>
                <input type="text" name="no_telefon_untuk_dihubungi">

                <label>Gambar Barang:</label>
                <input type="file" name="gambar" accept="image/*" required>

                <?php if ($peranan == 'sekolah/agensi'): ?>
                    <label>Nama Pelajar:</label>
                    <input type="text" name="nama_pelajar" required>

                    <label>Nama Sekolah:</label>
                    <input type="text" name="nama_sekolah" required>

                    <label>Kelas:</label>
                    <input type="text" name="kelas" required>
                <?php endif; ?>

                <label>Cadangan Tarikh Kutipan:</label>
                <input type="date" id="cadangan_tarikh_kutipan" name="cadangan_tarikh_kutipan" required>

                <button type="submit" class="nav-btn w-100">Hantar</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">✅ Berjaya!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4>Penghantaran anda telah berjaya dihantar!</h4>
                    <p class="text-muted">Terima kasih atas sumbangan anda kepada alam sekitar.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" onclick="redirectToList()">Lihat Senarai Penghantaran</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToList() {
            const peranan = '<?php echo $peranan; ?>';
            let redirectUrl;
            
            if (peranan === 'sekolah/agensi') {
                redirectUrl = 'sekolah_penghantaran.php';
            } else {
                redirectUrl = 'pengguna_penghantaran.php';
            }
            
            window.location.href = redirectUrl;
        }
    </script>
</body>

</html>