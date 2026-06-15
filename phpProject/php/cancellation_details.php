<?php
    session_start();
    if(!isset($_SESSION['c_id'])){
        echo '<script type="text/javascript">alert("Please Log In First"); window.location.href="login_page.php";</script>';
        exit();
    } 
    $logged = 1;
    $c_id = $_SESSION['c_id'];

    $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $cancellation_success = false;
    $cancellation_error = '';

    // Handle cancellation form submission (using GET as per the original form design)
    if (isset($_GET['hbk_id']) && isset($_GET['pmt_id'])) {
        $hbk_id = intval($_GET['hbk_id']);
        $pmt_id = intval($_GET['pmt_id']);
        $can_charge = doubleval($_GET['can_charge']);
        $ref_amt = doubleval($_GET['ref_amt']);

        // Verify if payment and booking belong to this customer
        $verify = mysqli_query($conn, "SELECT * FROM payment_details WHERE pmt_id=$pmt_id AND c_id=$c_id");
        if (mysqli_num_rows($verify) > 0) {
            // Check if already cancelled
            $chk = mysqli_query($conn, "SELECT * FROM cancellation_details WHERE pmt_id=$pmt_id");
            if (mysqli_num_rows($chk) == 0) {
                // Insert into cancellation details
                $q = "INSERT INTO cancellation_details (c_id, hbk_id, pmt_id, can_charge, ref_amt) VALUES ($c_id, $hbk_id, $pmt_id, $can_charge, $ref_amt)";
                if (mysqli_query($conn, $q)) {
                    // Update payment status to Cancelled
                    mysqli_query($conn, "UPDATE payment_details SET pmt_status='Cancelled' WHERE pmt_id=$pmt_id");
                    $cancellation_success = true;
                } else {
                    $cancellation_error = "Error saving cancellation details: " . mysqli_error($conn);
                }
            } else {
                $cancellation_error = "This payment booking has already been cancelled.";
            }
        } else {
            $cancellation_error = "Payment ID does not match our records for your account.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cancel Booking - PP travel ltd</title>
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
        <h2 class="text-center text-warning fw-bold text-uppercase mb-4">Booking Cancellation Form</h2>
        
        <?php if ($cancellation_success): ?>
            <div class="alert alert-success text-success border-0 shadow-sm text-center mb-4" style="background-color: rgba(16, 185, 129, 0.1) !important;">
                <strong>Success!</strong> Your cancellation has been processed. Refund has been logged and booking status is updated to Cancelled.
            </div>
        <?php endif; ?>
        <?php if ($cancellation_error): ?>
            <div class="alert alert-danger text-danger border-0 shadow-sm text-center mb-4" style="background-color: rgba(239, 68, 68, 0.1) !important;">
                <strong>Error!</strong> <?php echo htmlspecialchars($cancellation_error); ?>
            </div>
        <?php endif; ?>
        
        <?php
            if($logged==1){
        ?>
            <div class="box text-end mb-4">
                <a href="logout.php" class="btn btn-danger rounded-pill px-4 py-2 font-bold text-uppercase">Log Out</a>
            </div>
        <?php
            }
        ?>

        <form action="cancellation_details.php" method="get">
            <div class="row g-3">
                <!-- Customer ID -->
                <div class="col-md-6">
                    <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Customer ID</label>
                    <input type="text" class="form-control bg-dark bg-opacity-40 text-white border-secondary py-2" value="<?php echo $_SESSION['c_id']; ?>" disabled>
                </div>

                <!-- Hotel Booking ID -->
                <div class="col-md-6">
                    <label for="hbk_id" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Hotel Booking ID</label>
                    <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="hbk_id" name="hbk_id" placeholder="Hotel Booking ID" required>
                </div>

                <!-- Payment ID -->
                <div class="col-md-6">
                    <label for="pmt_id" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Payment ID</label>
                    <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="pmt_id" name="pmt_id" placeholder="Payment ID" required>
                </div>

                <!-- Cancellation Charge -->
                <div class="col-md-6">
                    <label for="can_charge" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Cancellation Charge</label>
                    <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="can_charge" name="can_charge" placeholder="Cancellation Charge" required>
                </div>

                <!-- Refund Amount -->
                <div class="col-12">
                    <label for="ref_amt" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Refund Amount</label>
                    <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="ref_amt" name="ref_amt" placeholder="Refund Amount" required>
                </div>

                <!-- Submit buttons -->
                <div class="col-12 d-flex gap-3 mt-4">
                    <button type="reset" class="btn btn-outline-secondary w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3">Clear</button>
                    <button type="submit" class="btn btn-warning w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3 shadow">Submit Cancellation</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
