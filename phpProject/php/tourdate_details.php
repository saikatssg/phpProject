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
<title>Journey Dates - PP travel ltd</title>
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
include "nav.php";
?>

<div class="container my-5" style="max-width: 900px;">
    <div class="text-center mb-5">
        <h1 class="display-4 font-bold tracking-wider uppercase text-warning">Select Tour Date</h1> 
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
            $query = "SELECT c.tc_id, c.strt_date, p.tp_name, p.tp_dur, p.tp_cost  FROM `tourconduction_details` c, tourpackage_details p WHERE c.tp_id=p.tp_id and tc_status=1";
            if(isset($_GET["tp_id"]))
            {
                $tp_id2=$_GET["tp_id"];
                $query.=" and c.tp_id=$tp_id2";
            }

            $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            if ($result = mysqli_query($link, $query)) {
                while ($row = mysqli_fetch_row($result)) {
                    echo '
                    <div class="card mb-4 bg-dark text-light border-secondary border-opacity-50 shadow animated-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <!-- Left: Date -->
                            <div class="col-md-3 text-center py-4 bg-black bg-opacity-20 d-flex flex-column justify-content-center align-items-center">
                                <span class="text-secondary text-xs uppercase tracking-wider mb-1">Start Date</span>
                                <span class="fw-bold fs-5 text-warning">'.$row[1].'</span>
                            </div>
                            <!-- Center: Package Info -->
                            <div class="col-md-6 border-start border-secondary border-opacity-10">
                                <div class="card-body p-4">
                                    <h4 class="text-light fw-bold mb-2">'.$row[2].'</h4>
                                    <div class="d-flex justify-content-start gap-4 mt-3">
                                        <div>
                                            <span class="text-secondary text-xs uppercase tracking-wider block">Duration</span>
                                            <p class="text-light fw-semibold mb-0">'.$row[3].'</p>
                                        </div>
                                        <div>
                                            <span class="text-secondary text-xs uppercase tracking-wider block">Price</span>
                                            <p class="text-warning fw-semibold mb-0">'.$row[4].'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Right: Action -->
                            <div class="col-md-3 text-center py-4 px-4 border-start border-secondary border-opacity-10">
                                <a href="bookings_details.php?tc_id='.$row[0].'&pname='.urlencode($row[2]).'&price='.urlencode($row[4]).'" class="btn btn-warning fw-bold text-uppercase w-100 py-2 rounded-pill shadow">Select</a>
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
