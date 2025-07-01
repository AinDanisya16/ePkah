<nav class="navbar navbar-expand-lg navbar-dark bg-success w-100">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="logo_epkah.png" alt="Logo" width="40" height="40" class="me-2">
    <span>e-PKAH</span>
  </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['nama'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item text-green fs-6" href="profile.php">👤 Profil Saya</a></li>
              <li><a class="dropdown-item text-green fs-6" href="logout.php">🚪 Log Keluar</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="index.php">🔐 Log Masuk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="signup.php">📝 Daftar</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script>
// Ensure dropdown works when navbar is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        console.log('Bootstrap available in navbar');
        
        // Initialize dropdown manually if needed
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        if (dropdownToggle) {
            console.log('Dropdown toggle found');
            
            // Add click event for debugging
            dropdownToggle.addEventListener('click', function(e) {
                console.log('Dropdown clicked');
            });
            
            // Initialize Bootstrap dropdown
            const dropdown = new bootstrap.Dropdown(dropdownToggle);
        } else {
            console.log('No dropdown toggle found');
        }
    } else {
        console.log('Bootstrap not available in navbar');
    }
});
</script>
