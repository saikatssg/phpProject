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
<title>Tour Conductions - PP travel ltd</title>
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
include "nav.php";
?>

<!-- Breadcrumb Page Header -->
<div class="luxury-page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold text-white mb-2" style="font-family: var(--font-serif) !important;">Tour Conductions</h1>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-white opacity-75 font-serif" style="font-style: italic; font-size: 1.1rem;">Scheduled Luxury Departures & Guided Tours</p>
    </div>
</div>

<div class="container my-5" style="max-width: 1000px;">
    <?php
	if($logged==1){
    ?>
        <div class="text-end mb-4">
            <a href="logout.php" class="btn btn-outline-danger px-4 py-2 font-bold text-uppercase" style="border-radius: 4px; font-size: 12px; font-weight: 700;">Log Out</a>
        </div>
    <?php
	}
    ?>

    <div class="row g-4 mt-2 justify-content-center">
        <div class="col-12">
            <?php
            $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            // Query joining c, p, and optionally pl to fetch location name
            $query = "SELECT c.tc_id, c.strt_date, p.tp_name, p.tp_dur, p.tp_cost, p.tp_id, p.tp_dtls, pl.p_name 
                      FROM `tourconduction_details` c
                      JOIN tourpackage_details p ON c.tp_id = p.tp_id
                      LEFT JOIN place_details pl ON p.p_id = pl.p_id
                      WHERE c.tc_status=1";

            if ($result = mysqli_query($link, $query)) {
                while ($row = mysqli_fetch_row($result)) {
                    $tc_id = htmlspecialchars($row[0]);
                    $start_date = htmlspecialchars($row[1]);
                    $tp_name = htmlspecialchars($row[2]);
                    $duration = htmlspecialchars($row[3]);
                    $price = htmlspecialchars($row[4]);
                    $tp_id = htmlspecialchars($row[5]);
                    $details = htmlspecialchars($row[6]);
                    $place_name = !empty($row[7]) ? htmlspecialchars($row[7]) : "Explore India";
                    
                    // Limit details description length for presentation
                    $desc_short = strlen($details) > 130 ? substr($details, 0, 127) . "..." : $details;
                    
                    echo '
                    <div class="card suntour-card mb-4 border-0 shadow-sm overflow-hidden">
                        <div class="row g-0">
                            <!-- Left Side: Details -->
                            <div class="col-md-7 d-flex flex-column justify-content-between p-4 bg-white">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h3 class="suntour-title mb-0">'.$tp_name.'</h3>
                                    </div>
                                    <div class="suntour-rating mb-2">★★★★★</div>
                                    
                                    <div class="suntour-price-sec mb-3">
                                        '.$price.'
                                        <span class="suntour-price-label">per person</span>
                                    </div>
                                    
                                    <p class="suntour-desc mb-4">'.$desc_short.'</p>
                                    
                                    <!-- Meta Details -->
                                    <div class="d-flex gap-4 mb-2 text-muted" style="font-size: 12px; font-weight: 500;">
                                        <div>
                                            <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: block; color: var(--color-gold); font-weight: 700;">Duration</span>
                                            <span>'.$duration.'</span>
                                        </div>
                                        <div>
                                            <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: block; color: var(--color-gold); font-weight: 700;">Start Date</span>
                                            <span>'.$start_date.'</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: #f1f3f5 !important;">
                                    <a href="tourdate_details.php?tp_id='.$tp_id.'" class="suntour-readmore text-decoration-none">READ MORE</a>
                                    <a href="bookings_details.php?tc_id='.$tc_id.'&pname='.urlencode($tp_name).'&price='.urlencode($price).'" class="btn-luxury-suntour">Select</a>
                                </div>
                            </div>
                            
                            <!-- Right Side: Image with Diagonal Clip-Path -->
                            <div class="col-md-5 position-relative suntour-img-sec">
                                <img src="../image/t_pkg/'.$tp_id.'.jpg" alt="'.$tp_name.'" class="suntour-img" onerror="this.src=\'../image/s1.jpg\'">
                                <div class="suntour-location-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                                    '.$place_name.'
                                </div>
                                <div class="suntour-discount-badge">10% Off</div>
                            </div>
                        </div>
                    </div>';
                }
                mysqli_free_result($result);
            }
            mysqli_close($link);
            ?>  
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
