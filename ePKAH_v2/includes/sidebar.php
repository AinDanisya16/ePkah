

<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-success ">

  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="home.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        🏠 <span class="ms-2 d-none d-sm-inline">Utama</span>
      </a>
    </li>

    <li>
      <a href="lokasi.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'lokasi.php' ? 'active  .bg-success.bg-gradient text-dark' : '' ?>">
        📍 <span class="ms-2 d-none d-sm-inline">Lokasi</span>
      </a>
    </li>

    <li>
      <a href="program.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'program.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        📅 <span class="ms-2 d-none d-sm-inline">Program</span>
      </a>
    </li>

  </ul>

  <hr>

  <!-- Role-based navigation -->
  <ul class="nav nav-pills flex-column mb-auto">
    <//?php if (isset($_SESSION['user'])): ?>

    <?php if (isset($_SESSION['peranan']) && $_SESSION['peranan']=='admin' ): ?>
    <li>
      <a href="admin_firstpage.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'admin_firstpage.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        👥 <span class="ms-2 d-none d-sm-inline">Dashboard Admin</span>
      </a>
    </li>
    <li>
      <a href="senarai_pengguna.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'senarai_pengguna.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        👥 <span class="ms-2 d-none d-sm-inline">Senarai Pengguna</span>
      </a>
    </li>
    <li>
      <a href="senarai_vendor.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'senarai_vendor.php' ? 'active .bg-success.bg-gradient text-dark' : '' ?>">
        🏭 <span class="ms-2 d-none d-sm-inline">Senarai Vendor</span>
      </a>
    </li>
    <li>
      <a href="admin_penghantaran.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'admin_penghantaran.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        🚚 <span class="ms-2 d-none d-sm-inline">Senarai Penghantaran</span>
      </a>
    </li>

    <?php elseif (isset($_SESSION['peranan']) && ($_SESSION['peranan']=='pengguna' || $_SESSION['peranan']=='sekolah/agensi')): ?>
    <li>
      <a href="recycle_info.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'recycle_info.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        👥 <span class="ms-2 d-none d-sm-inline">Dashboard</span>
      </a>
    </li>
    <li>
      <a href="hantar_kitar_semula.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'hantar_kitar_semula.php' ? 'active .bg-success.bg-gradient  text-dark' : '' ?>">
        ♻️ <span class="ms-2 d-none d-sm-inline">Hantar Kitar Semula</span>
      </a>
    </li>
    <li>
      <a href="pengguna_penghantaran.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'pengguna_penghantaran.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        📑 <span class="ms-2 d-none d-sm-inline">Penghantaran Saya</span>
      </a>
    </li>

    <?php elseif (isset($_SESSION['peranan']) && $_SESSION['peranan']=='vendor' ): ?>
    <li>
      <a href="vendor_penghantaran.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'vendor_penghantaran.php' ? 'active  .bg-success.bg-gradient text-dark' : '' ?>">
        📦 <span class="ms-2 d-none d-sm-inline">Penghantaran Masuk</span>
      </a>
    </li>
    <li>
      <a href="laporan_data_kutipan.php"
        class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'laporan_data_kutipan.php' ? 'active  .bg-success.bg-gradient  text-dark' : '' ?>">
        📊 <span class="ms-2 d-none d-sm-inline">Laporan</span>
      </a>
    </li>

    <?php endif; ?>

    <//?php endif; ?>
  </ul>
</div>