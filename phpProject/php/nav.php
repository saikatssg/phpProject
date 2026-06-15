<?php
// Ensure session is started if not already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$logged = 0;
if (isset($_SESSION['c_id']) && $_SESSION['c_id'] != null) {
    $logged = 1;
}
?>
<!-- Modern Luxury Split-Row Header -->
<nav class="navbar navbar-expand-lg fixed-top modern-navbar d-flex flex-column py-0">
  <!-- Top Row: Logo, Profile Status, Contact Phone -->
  <div class="navbar-top-row w-100">
    <div class="container-fluid max-width-container d-flex justify-content-between align-items-center px-4">
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo $logged ? 'home.php' : '../index.php'; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-cyan) !important;"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/><path d="M12 18a3 3 0 0 0 3-3c0-1.5-1.5-2.5-3-3.5-1.5 1-3 2-3 3.5a3 3 0 0 0 3 3z"/></svg>
        <div class="d-flex flex-column align-items-start leading-none">
          <span class="brand-text" style="font-size: 1.2rem; font-weight: 800; font-family: var(--font-serif); color: var(--color-navy); letter-spacing: 0.5px;">PP travel ltd</span>
        </div>
      </a>

      <div class="d-flex align-items-center gap-3">
        <?php 
           if($logged == 1) {
            echo '<div class="navbar-profile-badge d-flex align-items-center gap-2">';
            echo '  <div class="navbar-profile-avatar">'.strtoupper(substr($_SESSION['c_name'], 0, 1)).'</div>';
            echo '  <a href="home.php" class="navbar-profile-name text-decoration-none">'.$_SESSION['c_name'].'</a>';
            echo '  <a class="navbar-logout-btn" href="logout.php">Logout</a>';
            echo '</div>';
           } else {
            echo '<a class="navbar-login-btn" href="login_page.php">';
            echo '  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>';
            echo '  Login / Register';
            echo '</a>';
           }
        ?>
        <a href="tel:1234567890" class="cyan-callout-badge d-none d-sm-inline-flex">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          123 456 7890
        </a>

        <!-- Hamburger Icon (visible on mobile only) -->
        <button class="navbar-toggler modern-navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="toggler-icon-bar top-bar"></span>
          <span class="toggler-icon-bar middle-bar"></span>
          <span class="toggler-icon-bar bottom-bar"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- Bottom Row: Navigation Links -->
  <div class="navbar-bottom-row collapse navbar-collapse w-100" id="navbarSupportedContent">
    <div class="container-fluid max-width-container px-4">
      <ul class="navbar-nav mx-auto gap-1 justify-content-center align-items-center flex-column flex-lg-row">
        <?php if($logged == 1): ?>
        <li class="nav-item">
          <a class="nav-link" id="dashboard" href="home.php">Dashboard</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="about_us.php">About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact_us.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="state1.php">Explorable Places</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tourpackages.php">Tour Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tourconductions_details.php">Tour Conduction</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="states.php">Hotel Booking</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
