<?php
	session_start();
	$logged=0;
	
	if(!isset($_SESSION['c_id'])){
?>
<script type="text/javascript">
		alert("Please Log In First");
		window.location.href="login_page.php";
</script>
<?php
		exit();
	} 
	else if(isset($_SESSION['c_id']) && 
		$_SESSION['c_id']!= null){
		$logged=1;
	}

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $tc_id = isset($_GET["tc_id"]) ? intval($_GET["tc_id"]) : 0;
    $tp_id = 0;
    $actual_start_date = '';
    $tp_name = isset($_GET["pname"]) ? $_GET["pname"] : '';
    $price = isset($_GET["price"]) ? $_GET["price"] : '';

    if ($tc_id > 0) {
        $tc_query = "SELECT c.strt_date, c.tp_id, p.tp_name, p.tp_cost 
                     FROM tourconduction_details c 
                     JOIN tourpackage_details p ON c.tp_id = p.tp_id 
                     WHERE c.tc_id = $tc_id";
        $tc_res = mysqli_query($conn, $tc_query);
        if ($tc_res && $row = mysqli_fetch_assoc($tc_res)) {
            $actual_start_date = $row['strt_date'];
            $tp_id = intval($row['tp_id']);
            $tp_name = $row['tp_name'];
            $price = $row['tp_cost'];
        }
    }

    // Query other active conduction times for this package (next available departures)
    $other_conductions = [];
    if ($tp_id > 0) {
        $other_query = "SELECT tc_id, strt_date FROM tourconduction_details 
                        WHERE tp_id = $tp_id AND tc_status = 1 AND tc_id != $tc_id 
                        ORDER BY tc_id ASC";
        $other_res = mysqli_query($conn, $other_query);
        if ($other_res) {
            while ($orow = mysqli_fetch_assoc($other_res)) {
                $other_conductions[] = $orow;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Booking - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/modern_ui.css">

<style>
    body {
        background: linear-gradient(rgba(12, 35, 64, 0.35), rgba(12, 35, 64, 0.45)), url(../image/slider-one.jpg) center/cover fixed no-repeat !important;
        padding-top: 170px !important;
        background-size: cover !important;
        background-position: bottom !important;
    }
    .form-card {
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
        border-radius: 6px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25) !important;
        color: var(--color-navy);
        width: 100%;
        padding: 40px !important;
        box-sizing: border-box !important;
    }
</style>
</head>

<body>
<?php
include "nav.php";
?>

<div class="container my-5" style="max-width: 680px;">
    <div class="form-card">
        <h3 class="text-center mb-2 text-uppercase fw-bold" style="color: var(--color-navy); font-family: var(--font-serif); letter-spacing: 1px;">Tour Booking Information</h3>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        
        <?php if($logged==1): ?>
            <div class="box text-end mb-4">
                <a href="logout.php" class="btn btn-outline-danger px-3 py-1 font-bold text-uppercase" style="font-size: 11px; border-radius: 4px;">Log Out</a>
            </div>
        <?php endif; ?>

        <!-- Next Available Tour Conductions Info -->
        <?php if (!empty($other_conductions)): ?>
            <div class="alert alert-warning border-0 p-3 mb-4 rounded-3 text-navy bg-warning bg-opacity-10 d-flex flex-column gap-2" style="font-size: 12px; border-left: 4px solid var(--color-gold) !important;">
                <span class="fw-bold"><span style="font-size: 14px;">📅</span> Other Available Departures for this Package:</span>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    <?php foreach ($other_conductions as $ocond): ?>
                        <a href="bookings_details.php?tc_id=<?php echo $ocond['tc_id']; ?>&pname=<?php echo urlencode($tp_name); ?>&price=<?php echo urlencode($price); ?>" class="btn btn-sm btn-outline-secondary py-1 px-2.5 text-navy font-semibold rounded-pill" style="font-size: 10.5px; border-color: rgba(12, 35, 64, 0.2); background-color: rgba(255,255,255,0.8);">
                            📅 <?php echo htmlspecialchars($ocond['strt_date']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="booking_details.php" method="get" onsubmit="return validateBookingDate(event)">
            <div class="row g-3">
                <!-- Actual Tour Start Date display -->
                <div class="col-md-12">
                    <div class="p-3 border rounded-3 bg-light bg-opacity-50 d-flex justify-content-between align-items-center mb-2" style="border-color:#e1e8ed !important;">
                        <div>
                            <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">Scheduled Tour Departure Date</span>
                            <span class="fw-bold text-navy fs-5">📅 <?php echo htmlspecialchars($actual_start_date ?: 'Pending Departure Date'); ?></span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded" style="font-size:10px; font-weight:700;">Active Departure</span>
                    </div>
                </div>

                <!-- Customer ID -->
                <div class="col-md-6">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy); margin-bottom: 8px; display: block;">Customer ID</label>
                    <input type="text" class="form-control bg-light text-dark border-secondary py-2" value="<?php echo $_SESSION['c_id']; ?>" disabled style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                </div>

                <!-- Package Name -->
                <div class="col-md-6">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy); margin-bottom: 8px; display: block;">Package Name</label>
                    <input type="text" class="form-control bg-light text-dark border-secondary py-2" value="<?php echo htmlspecialchars($tp_name); ?>" disabled style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                    <input type="hidden" name="pname" value="<?php echo htmlspecialchars($tp_name); ?>">
                </div>

                <!-- Booking Person count -->
                <div class="col-md-6">
                    <label for="bk_person" class="form-label font-bold text-xs uppercase" style="color: var(--color-navy); margin-bottom: 8px; display: block;">Booking Persons</label>
                    <select name="bk_person" id="bk_person" class="form-select bg-white text-dark border-secondary" style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                        <?php
                        for($i=1; $i<=100; $i++){
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Booking Date -->
                <div class="col-md-6">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy); margin-bottom: 8px; display: block;">Booking Date</label>
                    <div class="d-flex gap-2">
                        <select name="DD" class="form-select bg-white text-dark border-secondary" style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                            <?php
                            $today_d = intval(date('d'));
                            for($i=1; $i<=31; $i++){
                                $selected = ($i === $today_d) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="MM" class="form-select bg-white text-dark border-secondary" style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                            <?php
                            $today_m = intval(date('m'));
                            for($i=1; $i<=12; $i++){
                                $selected = ($i === $today_m) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="YY" class="form-select bg-white text-dark border-secondary" style="border-color: #ccd6dd !important; color: #2c3e50 !important; height: 42px;">
                            <?php
                            $today_y = intval(date('Y'));
                            ?>
                            <option value="2018" <?php echo ($today_y === 2018) ? 'selected' : ''; ?>>2018</option>
                            <option value="2026" <?php echo ($today_y === 2026) ? 'selected' : ''; ?>>2026</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden parameters -->
                <input type="hidden" name="tc_id" value="<?php echo $tc_id; ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

                <!-- Submit buttons -->
                <div class="col-12 d-flex gap-3 mt-4">
                    <button type="reset" class="btn btn-outline-secondary w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-pill" style="color: var(--color-navy); border-color: var(--color-navy);">Clear</button>
                    <button type="submit" class="btn btn-luxury w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-pill shadow">Submit Booking</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript validation checking for Date Conflicts -->
<script>
function validateBookingDate(event) {
    const d = parseInt(document.querySelector('select[name="DD"]').value);
    const m = parseInt(document.querySelector('select[name="MM"]').value);
    const y = parseInt(document.querySelector('select[name="YY"]').value);
    
    const selectedDate = new Date(y, m - 1, d);
    selectedDate.setHours(0, 0, 0, 0);
    
    const startStr = "<?php echo $actual_start_date; ?>";
    if (startStr !== '') {
        const parts = startStr.split('/');
        if (parts.length === 3) {
            const startDate = new Date(parseInt(parts[2]), parseInt(parts[1]) - 1, parseInt(parts[0]));
            startDate.setHours(0, 0, 0, 0);
            
            if (selectedDate > startDate) {
                alert("Error: Booking date cannot be after the actual tour start date (" + startStr + ").");
                event.preventDefault();
                return false;
            }
        }
    }
    return true;
}
</script>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
