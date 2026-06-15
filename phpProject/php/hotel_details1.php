<?php
	session_start();
?>
<?php
	$logged=0;
	if(isset($_SESSION['c_id']) && 
		$_SESSION['c_id']!= null){
		$logged=1;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotels - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/modern_ui.css">

<style>
    body {
        padding-top: 100px;
    }
</style>
</head>
<body>

<?php
include "nav2.php";
?>

<div class="container my-5" style="max-width: 1000px;">
    <div class="text-center mb-5">
        <h1 class="display-4 font-bold tracking-wider uppercase text-warning">Hotel Details</h1> 
    </div>

    <?php
	if($logged==1){
    ?>
        <div class="box text-end mb-4">
            <a href="logout.php" class="btn btn-danger rounded-pill px-4 py-2 font-bold text-uppercase">Log Out</a>
        </div>
    <?php
	}
    ?>

    <div class="row g-4 mt-2">
        <div class="col-12">
            <?php
            $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            $query = "SELECT * FROM hotel_details";
            if(isset($_GET["val"])){
                $val=$_GET["val"];
                $query.=" where st_id=".$val;
            }

            if ($result = mysqli_query($link, $query)) {
                while ($row = mysqli_fetch_row($result)) {
                    echo '
                    <div class="card mb-4 bg-dark text-light border-secondary border-opacity-50 shadow animated-card overflow-hidden">
                        <div class="row g-0 align-items-stretch">
                            <div class="col-md-3">
                                <img src="../image/Hotel/'.$row[0].'.jpg" class="img-fluid h-100 w-100" alt="'.$row[1].'" style="object-fit: cover; min-height: 200px;">
                            </div>
                            <div class="col-md-6 border-start border-secondary border-opacity-10">
                                <div class="card-body p-4 d-flex flex-column h-100 justify-content-center">
                                    <h3 class="card-title text-warning fw-bold mb-2">
                                        <a href="../pdf/'.$row[0].'.pdf" target="_blank" class="text-warning text-decoration-none hover-underline">'.$row[1].'</a>
                                    </h3>
                                    <p class="card-text text-secondary mb-1"><strong>Location:</strong> '.$row[2].', '.$row[3].'</p>
                                    <p class="card-text text-secondary mb-0" style="text-align: justify;">'.$row[6].'</p>
                                </div>
                            </div>
                            <div class="col-md-3 text-center border-start border-secondary border-opacity-10 py-4 px-4 d-flex flex-column justify-content-center align-items-center bg-black bg-opacity-20">
                                <span class="text-secondary text-xs uppercase tracking-wider mb-1">Rate</span>
                                <span class="fw-bold fs-4 text-warning mb-4">'.$row[5].'</span>
                                <a href="hotel_bookings_details.php?h_id='.urlencode($row[0]).'&h_name='.urlencode($row[1]).'&h_rate='.urlencode($row[5]).'" class="btn btn-warning fw-bold text-uppercase w-100 py-2 rounded-3">Book Hotel</a>
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
