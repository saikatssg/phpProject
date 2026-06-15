<?php
	session_start();
?>
<?php
	if(!isset($_SESSION['c_id'])){
?>
<script type="text/javascript">
		alert("Please Log In First");
		window.location.href="login_page.php";
</script>
<?php
	} 
    $h_id = isset($_GET["h_id"]) ? intval($_GET["h_id"]) : 0;
    $h_name = isset($_GET["h_name"]) ? $_GET["h_name"] : "";
    $h_rate = isset($_GET["h_rate"]) ? $_GET["h_rate"] : "";

    // Read session quick-booking data if available
    $session_arrival = isset($_SESSION['arrival']) ? $_SESSION['arrival'] : '';
    $session_departure = isset($_SESSION['departure']) ? $_SESSION['departure'] : '';
    $session_rooms = isset($_SESSION['rooms']) ? intval($_SESSION['rooms']) : 1;
    $session_guests = isset($_SESSION['guests']) ? intval($_SESSION['guests']) : 1;
    $session_children = isset($_SESSION['children']) ? intval($_SESSION['children']) : 0;

    $check_in_day = 1;
    $check_in_month = 6;
    $check_in_year = 2026;
    if (!empty($session_arrival)) {
        $parts = explode('-', $session_arrival);
        if (count($parts) == 3) {
            $check_in_year = intval($parts[0]);
            $check_in_month = intval($parts[1]);
            $check_in_day = intval($parts[2]);
        }
    }

    $check_out_day = 2;
    $check_out_month = 6;
    $check_out_year = 2026;
    if (!empty($session_departure)) {
        $parts = explode('-', $session_departure);
        if (count($parts) == 3) {
            $check_out_year = intval($parts[0]);
            $check_out_month = intval($parts[1]);
            $check_out_day = intval($parts[2]);
        }
    }

    $today_day = intval(date('d'));
    $today_month = intval(date('m'));
    $today_year = intval(date('Y'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel Booking - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/modern_ui.css">

<style>
    body {
        padding-top: 100px;
    }
    .form-card {
        background: rgba(30, 41, 59, 0.45) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        color: #fff;
    }
</style>
</head>

<body>
<?php
include "nav.php";
?>

<div class="container my-5" style="max-width: 750px;">
    <div class="form-card p-5">
        <h2 class="text-center text-warning fw-bold text-uppercase mb-4">Hotel Booking Information</h2>
        
        <form action="hotelbooking_details.php" method="get">
            <div class="row g-3">
                <!-- Customer ID -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Customer ID</label>
                    <input type="text" class="form-control bg-dark bg-opacity-40 text-white border-secondary py-2" value="<?php echo $_SESSION['c_id']; ?>" disabled>
                </div>

                <!-- Hotel Name -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Hotel Name</label>
                    <input type="text" class="form-control bg-dark bg-opacity-40 text-white border-secondary py-2" value="<?php echo htmlspecialchars($h_name); ?>" disabled>
                    <input type="hidden" name="h_name" value="<?php echo htmlspecialchars($h_name); ?>">
                    <input type="hidden" name="h_id" value="<?php echo $h_id; ?>">
                </div>

                <!-- Rooms -->
                <div class="col-md-6">
                    <label for="rooms" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Rooms</label>
                    <select name="rooms" id="rooms" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                        <?php
                        for($i=1; $i<=3; $i++){
                            $selected = ($i == $session_rooms) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i Room" . ($i > 1 ? "s" : "") . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Adults (Booking Persons) -->
                <div class="col-md-6">
                    <label for="bk_person" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Adults</label>
                    <select name="bk_person" id="bk_person" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                        <?php
                        for($i=1; $i<=10; $i++){
                            $selected = ($i == $session_guests) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Children -->
                <div class="col-md-6">
                    <label for="children" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Children</label>
                    <select name="children" id="children" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                        <?php
                        for($i=0; $i<=3; $i++){
                            $selected = ($i == $session_children) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Room Type -->
                <div class="col-md-6">
                    <label for="rm_type" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Room Type</label>
                    <select name="rm_type" id="rm_type" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                        <option value="AC">AC Room</option>
                        <option value="Non-AC">Non-AC Room</option>
                    </select>
                </div>

                <!-- Booking Date -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Booking Date</label>
                    <div class="d-flex gap-2">
                        <select name="DD" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=31; $i++){
                                $selected = ($i == $today_day) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="MM" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=12; $i++){
                                $selected = ($i == $today_month) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="YY" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <option value="2018">2018</option>
                            <option value="2026" <?php if($today_year == 2026) echo 'selected'; ?>>2026</option>
                        </select>
                    </div>
                </div>

                <!-- Check-in Date -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Check-In Date</label>
                    <div class="d-flex gap-2">
                        <select name="check_in_DD" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=31; $i++){
                                $selected = ($i == $check_in_day) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="check_in_MM" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=12; $i++){
                                $selected = ($i == $check_in_month) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="check_in_YY" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <option value="2018">2018</option>
                            <option value="2026" <?php if($check_in_year == 2026) echo 'selected'; ?>>2026</option>
                        </select>
                    </div>
                </div>

                <!-- Check-out Date -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Check-Out Date</label>
                    <div class="d-flex gap-2">
                        <select name="check_out_DD" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=31; $i++){
                                $selected = ($i == $check_out_day) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="check_out_MM" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <?php
                            for($i=1; $i<=12; $i++){
                                $selected = ($i == $check_out_month) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="check_out_YY" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                            <option value="2018">2018</option>
                            <option value="2026" <?php if($check_out_year == 2026) echo 'selected'; ?>>2026</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden parameters -->
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($h_rate); ?>">

                <!-- Submit buttons -->
                <div class="col-12 d-flex gap-3 mt-4">
                    <button type="reset" class="btn btn-outline-secondary w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3">Clear</button>
                    <button type="submit" class="btn btn-warning w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3 shadow">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
