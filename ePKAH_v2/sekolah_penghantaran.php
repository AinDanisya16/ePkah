<!DOCTYPE html>
<html lang="ms">

<head>
  <meta charset="UTF-8">
  <title>Senarai Penghantaran Sekolah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
      <h2>Senarai Penghantaran oleh Sekolah</h2>
      <table>
        <thead>
          <tr>
            <th>Tarikh Hantar</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Alamat</th>
            <th>Nama Sekolah</th>
            <th>Kelas</th>
            <th>Nama Pelajar</th>
            <th>Tarikh Kutipan</th>
            <th>Gambar</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['tarikh_hantar']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['jenis']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['nama_sekolah']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td><?= htmlspecialchars($row['nama_pelajar']) ?></td>
                <td><?= htmlspecialchars($row['cadangan_tarikh_kutipan']) ?></td>
                <td>
                  <?php if ($row['gambar']): ?>
                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" style="width:100px;">
                  <?php else: ?>
                    Tiada
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7">Tiada penghantaran direkodkan.</td>
            </tr>

          <?php endif; ?>
        </tbody>
      </table>


      <?php $stmt->close();
      $conn->close(); ?>
    </div>
  </div>

</body>

</html>