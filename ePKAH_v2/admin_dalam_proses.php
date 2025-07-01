<!DOCTYPE html>
<html>

<head>
    <title>Penghantaran Dalam Proses</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

</head>

<body>
    <div class="wrapper">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="main-content">
            <h2>Senarai Penghantaran Diterima Admin (Dalam Proses)</h2>

            <div style="margin-bottom: 20px;">
                <a href="admin_penghantaran.php" class="nav-btn semakan">📩 Dalam Semakan</a>
                <a href="admin_dalam_proses.php" class="nav-btn proses">📦 Dalam Proses</a>
                <a href="admin_ditolak.php" class="nav-btn ditolak">❌ Ditolak</a>
                <a href="admin_selesai.php" class="nav-btn selesai-nav">✅ Selesai</a>
            </div>

            <table id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pengguna</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Alamat</th>
                        <th>Tarikh</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= $row['kategori'] ?></td>
                            <td><?= $row['jenis'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td><?= $row['status_penghantaran'] ?></td>
                            <td>
                                <a class="btn btn-tindakan" href="admin_proses.php?id=<?= $row['id'] ?>&aksi=selesai">✅
                                    Tandakan
                                    Selesai</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

            <div class="menu">
                <a href="admin_dashboard.php">🏠 Kembali ke Dashboard</a>
                <a href="logout.php">🚪 Log Keluar</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "order": [], // no default sorting
                "columnDefs": [
                    { "orderable": false, "targets": 7 } // disable sorting on 'Tindakan' column
                ]
            });
        });
    </script>


</body>

</html>