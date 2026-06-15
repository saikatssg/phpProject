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
<title>Discover States - PP travel ltd</title>
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
        <h1 class="display-4 fw-bold text-white mb-2" style="font-family: var(--font-serif) !important;">Discover By States</h1>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-white opacity-75 font-serif" style="font-style: italic; font-size: 1.1rem;">Explore the Beauty of Indian States</p>
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

    <?php
    $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	$query = "SELECT * FROM state_details LIMIT 0,6";

    if ($result = mysqli_query($link, $query)) {
        echo '<div class="row g-4 justify-content-center">';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                    <div class="position-relative overflow-hidden" style="height: 240px; border-top-left-radius: 6px; border-top-right-radius: 6px;">
                        <img src="../image/State/'.htmlspecialchars($row['st_id']).'.jpg" class="w-100 h-100" alt="'.htmlspecialchars($row['st_name']).'" style="object-fit: cover; transition: transform 0.4s ease;">
                    </div>
                    <div class="card-body d-flex flex-column p-4 bg-white" style="border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                        <h4 class="card-title text-primary fw-bold mb-3" style="font-family: var(--font-serif) !important;">'.htmlspecialchars($row['st_name']).'</h4>
                        <p class="card-text text-muted flex-grow-1" style="text-align: justify; font-size: 13.5px; line-height: 1.6;">'.htmlspecialchars($row['st_details']).'</p>
                        <a href="places.php?val='.htmlspecialchars($row['st_id']).'" class="btn btn-luxury mt-4 w-100 py-2">Explore Places</a>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
        mysqli_free_result($result);
    }
    mysqli_close($link);
    ?>  
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
