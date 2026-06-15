<?php
session_start();

if (!isset($_SESSION['c_id'])) {
    header("Location: login_page.php");
    exit();
}

$c_id = $_SESSION['c_id'];
$hbk_id = isset($_GET["hbk_id"]) ? intval($_GET["hbk_id"]) : 0;
$raw_price = isset($_GET["price"]) ? $_GET["price"] : "0";
// Clean "Rs." or any non-numeric symbols if present
$pmt_amt = doubleval(preg_replace('/[^\d.]/', '', $raw_price));

$DD = isset($_GET["DD"]) ? intval($_GET["DD"]) : intval(date('d'));
$MM = isset($_GET["MM"]) ? intval($_GET["MM"]) : intval(date('m'));
$YY = isset($_GET["YY"]) ? intval($_GET["YY"]) : intval(date('Y'));
$pmt_date = "$YY-" . sprintf("%02d", $MM) . "-" . sprintf("%02d", $DD);

$pmt_status = "Pending";
$pmt_type = isset($_GET["money"]) ? $_GET["money"] : "neft";

$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book") or die("Connection failed");

$booking_type = isset($_GET["booking_type"]) ? mysqli_real_escape_string($conn, $_GET["booking_type"]) : "tour";

$query = "INSERT INTO payment_details (c_id, hbk_id, pmt_amt, pmt_date, pmt_status, pmt_type, booking_type) VALUES ('$c_id', '$hbk_id', '$pmt_amt', '$pmt_date', '$pmt_status', '$pmt_type', '$booking_type')";
$res = mysqli_query($conn, $query);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - PP travel ltd</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/modern_ui.css">
    <style>
        body {
            padding-top: 120px !important;
            background-color: var(--color-bg-gray) !important;
        }
        .success-card {
            background-color: #ffffff;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(223, 169, 32, 0.1);
            color: var(--color-gold);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 32px;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>

    <div class="container success-card p-5">
        <div class="success-icon">
            ✓
        </div>
        <h2 class="text-uppercase fw-bold mb-2" style="font-family: var(--font-serif) !important; color: var(--color-navy) !important;">Booking Confirmed</h2>
        <div class="deco-divider">
            <span class="deco-divider-icon">⚜</span>
        </div>
        
        <?php if ($res) { ?>
            <p class="fs-5 text-dark mb-4 px-3" style="border: none !important; background-color: transparent !important; padding: 0 !important;">
                Thank you! Your booking reservation has been completed and payment has been logged successfully for admin verification.
            </p>
            <div class="bg-light p-4 rounded text-start mb-4 border" style="border-color: #e1e8ed !important;">
                <div class="row g-2">
                    <div class="col-6 text-muted">Booking Reference:</div>
                    <div class="col-6 fw-bold text-dark text-end">#<?php echo strtoupper($booking_type == 'hotel' ? 'HBK' : 'TC'); ?>-<?php echo $hbk_id; ?></div>
                    
                    <div class="col-6 text-muted">Amount Charged:</div>
                    <div class="col-6 fw-bold text-dark text-end">INR <?php echo number_format($pmt_amt, 2); ?></div>
                    
                    <div class="col-6 text-muted">Payment Mode:</div>
                    <div class="col-6 fw-bold text-dark text-end text-uppercase"><?php echo htmlspecialchars($pmt_type); ?></div>
                    
                    <div class="col-6 text-muted">Date:</div>
                    <div class="col-6 fw-bold text-dark text-end"><?php echo htmlspecialchars($pmt_date); ?></div>
                </div>
            </div>
        <?php } else { ?>
            <p class="fs-5 text-danger mb-4" style="border: none !important; background-color: transparent !important; padding: 0 !important;">
                There was an error completing your payment record, but your booking was logged. Please contact administration.
            </p>
        <?php } ?>

        <div class="d-flex flex-column gap-3 max-w-sm mx-auto mt-4" style="max-width: 300px; margin: 0 auto;">
            <a href="home.php" class="btn btn-luxury py-2.5 fw-bold text-uppercase tracking-wider shadow">Go to Dashboard</a>
            <a href="../index.php" class="btn btn-outline-secondary py-2 fw-bold text-uppercase tracking-wider">Back to Home</a>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
