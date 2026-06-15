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
<title>Contact Us - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/modern_ui.css">

<style>
    body {
        padding-top: 150px !important;
        background-color: var(--color-bg-gray) !important;
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
        <h1 class="display-4 fw-bold text-white mb-2" style="font-family: var(--font-serif) !important;">Contact Us</h1>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-white opacity-75 font-serif" style="font-style: italic; font-size: 1.1rem;">We Value Your Feedback & Queries</p>
    </div>
</div>

<div class="container my-5 bg-transparent border-0 shadow-none">
    <div class="luxury-split-container">
        <!-- Left Side: Resort Graphic -->
        <div class="left" style="background: linear-gradient(rgba(12, 35, 64, 0.1), rgba(12, 35, 64, 0.3)), url('../image/s3.jpg') center/cover no-repeat; min-height: 520px;"></div>
        
        <!-- Right Side: Feedback Form -->
        <div class="right p-5">
            <h3 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif) !important;">Your Feedback</h3>
            
            <form method="post" action="#">
                <div class="mb-3">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="user" placeholder="Enter your full name" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>

                <div class="mb-3">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" placeholder="Enter your address" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>

                <div class="mb-3">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email ID" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>

                <div class="mb-3">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="mobile" placeholder="Enter your mobile number" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>

                <div class="mb-4">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Query Text <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="query" placeholder="Type your query here..." required style="border-color: #ccd6dd !important; color: #2c3e50 !important; min-height: 100px;"></textarea>
                </div>
                
                <button type="submit" class="btn btn-luxury w-100 py-3 fw-bold text-uppercase tracking-wide shadow mt-2">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
