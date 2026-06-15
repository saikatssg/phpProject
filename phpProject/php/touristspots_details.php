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
<title>Tourist Spots - PP travel ltd</title>
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

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-4 font-bold tracking-wider uppercase text-warning">Tourist Spots</h1> 
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

    <?php
    $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $p_id=$_GET["val"];
	$query = "SELECT * FROM touristspot_details where p_id=$p_id limit 0,4";

    if ($result = mysqli_query($link, $query)) {
        echo '<div class="row g-4 justify-content-center">';

        while ($row = mysqli_fetch_row($result)) {
            // Card 1
            echo '
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="card h-100 bg-dark text-light border-secondary border-opacity-50 shadow-lg animated-card">
                    <img src="../image/t_spot/'.$row[0].'.jpg" class="card-img-top" alt="'.$row[1].'" style="height: 240px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <h4 class="card-title text-warning fw-bold mb-3">'.$row[1].'</h4>
                        <p class="card-text text-secondary flex-grow-1" style="text-align: justify; line-height: 1.6;">'.$row[2].'</p>
                    </div>
                </div>
            </div>';
            
            // Card 2
            $row = mysqli_fetch_row($result);
            if ($row) {
                echo '
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="card h-100 bg-dark text-light border-secondary border-opacity-50 shadow-lg animated-card">
                        <img src="../image/t_spot/'.$row[0].'.jpg" class="card-img-top" alt="'.$row[1].'" style="height: 240px; object-fit: cover;">
                        <div class="card-body d-flex flex-column p-4">
                            <h4 class="card-title text-warning fw-bold mb-3">'.$row[1].'</h4>
                            <p class="card-text text-secondary flex-grow-1" style="text-align: justify; line-height: 1.6;">'.$row[2].'</p>
                        </div>
                    </div>
                </div>';
            }
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
