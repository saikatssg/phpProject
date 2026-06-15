<?php
	session_start();
	$logged=0;
	if(isset($_SESSION['c_id']) && $_SESSION['c_id']!= null){
		$logged=1;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/modern_ui.css">

<style>
    body {
        padding-top: 150px !important;
        background-color: var(--color-bg-gray) !important;
    }
    
    .dropcap {
        margin: 5px 15px 5px 0;
        float: left;
        font-size: 75px;
        line-height: 60px;
        font-family: var(--font-serif) !important;
        color: var(--color-gold) !important;
        font-weight: 800;
        text-transform: uppercase;
    }
    
    .about-story-card {
        background-color: #ffffff;
        border: 1px solid #e1e8ed;
        border-radius: 6px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
</style>
</head>
<body>

<?php
include "nav2.php";
?>

<!-- Breadcrumb Page Header -->
<div class="luxury-page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold text-white mb-2" style="font-family: var(--font-serif) !important;">About Us</h1>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-white opacity-75 font-serif" style="font-style: italic; font-size: 1.1rem;">PP Travels & Hotel Booking Story</p>
    </div>
</div>

<div class="container my-5">
    <?php
	if($logged==1){
    ?>
        <div class="text-end mb-4">
            <a href="logout.php" class="btn btn-outline-danger px-4 py-2 font-bold text-uppercase" style="border-radius: 4px; font-size: 12px; font-weight: 700;">Log Out</a>
        </div>
    <?php
	}
    ?>

    <div class="card about-story-card p-5 border-0">
        <div class="row align-items-center g-5">
            <!-- Left: About Image -->
            <div class="col-lg-5">
                <div class="position-relative overflow-hidden rounded shadow" style="height: 380px;">
                    <img src="../image/s1.jpg" class="w-100 h-100" alt="Resort View" style="object-fit: cover;">
                </div>
            </div>
            
            <!-- Right: Content -->
            <div class="col-lg-7">
                <h3 class="fw-bold mb-1" style="color: var(--color-navy); font-family: var(--font-serif) !important;">Our Story</h3>
                <div class="deco-divider justify-content-start" style="margin: 10px 0 25px 0 !important;">
                    <span class="deco-divider-icon">⚜</span>
                </div>
                
                <p class="text-dark" style="text-align: justify; font-size: 15px; line-height: 1.8; border: none !important; background-color: transparent !important; padding: 0 !important;">
                    <span class="dropcap">P</span>&amp;P Tours &amp; Travels, the vanguard of Indian Tourism Industries. Over years and decades, this organisation has conducted thousands of tour programmes, earning the lofty blessings of countless tourists. The fame of this organisation is not confined to this region only; it has spread to various states of India and even among non-residents because of its familiarity and commitment to quality.
                </p>
                
                <p class="text-dark mt-3" style="text-align: justify; font-size: 15px; line-height: 1.8; border: none !important; background-color: transparent !important; padding: 0 !important;">
                    Besides, this very name has also found place in various writings of newspapers like Anandobazaar Patrika, Bartoman Patrika, and Protidin, which have echoed this organisation's hospitality in their writings. The list of clientele of "JP Tours &amp; Travels" includes a large number of celebrities through generations. The capital of endearing loves, warm affection, and goodwill of innumerable tourists just prompt us even today, after seventy-six years, to stride ahead further with determination to offer still better and more attractive services.
                </p>
                
                <p class="text-muted font-serif mt-4 mb-0" style="font-style: italic; border: none !important; background-color: transparent !important; padding: 0 !important;">
                    Thanks For Visiting Our Page.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
