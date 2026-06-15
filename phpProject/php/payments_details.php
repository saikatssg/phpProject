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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel Payment - PP travel ltd</title>
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

<div class="container my-5" style="max-width: 900px;">
    <div class="checkout-card p-5">
        <h2 class="text-center text-warning fw-bold text-uppercase mb-5">Secure checkout</h2>
        
        <form action="../php/payment_details.php" method="get">
            <div class="row g-4">
                <!-- Left: Mockup Card Display -->
                <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center">
                    <div class="credit-card-mock w-100">
                        <div class="credit-card-chip"></div>
                        <div class="credit-card-number mb-4 text-center">4532 •••• •••• 8824</div>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <div>
                                <div class="credit-card-holder">Card Holder</div>
                                <div class="text-white fw-bold text-sm">CUSTOMER ACCOUNT</div>
                            </div>
                            <div>
                                <div class="credit-card-holder">Expires</div>
                                <div class="text-white fw-bold text-sm">12/28</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-secondary bg-dark bg-opacity-20 border-secondary text-secondary text-xs text-center w-100 py-2 rounded-3">
                        🔒 Safe & Secure 256-bit SSL checkout
                    </div>
                </div>

                <!-- Right: Form inputs -->
                <div class="col-lg-7">
                    <div class="row g-3">
                        <!-- Customer ID -->
                        <div class="col-md-6">
                            <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Customer ID</label>
                            <input type="text" class="form-control bg-dark bg-opacity-40 text-white border-secondary py-2" value="<?php echo $_SESSION['c_id']; ?>" disabled>
                            <input type="hidden" name="c_id" value="<?php echo $_SESSION['c_id']; ?>">
                        </div>

                        <!-- Hotel Booking ID -->
                        <div class="col-md-6">
                            <label for="hbk_id" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Hotel Booking ID</label>
                            <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="hbk_id" name="hbk_id" placeholder="Hotel Booking ID" required>
                        </div>

                        <!-- Payment Amount -->
                        <div class="col-12">
                            <label for="pmt_amt" class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Payment Amount (INR)</label>
                            <input type="text" class="form-control bg-dark bg-opacity-20 text-white border-secondary py-2" id="pmt_amt" name="pmt_amt" placeholder="Payment Amount" required>
                        </div>

                        <!-- Payment Date -->
                        <div class="col-12">
                            <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Payment Date</label>
                            <div class="d-flex gap-2">
                                <select name="DD" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                                    <?php
                                    for($i=1; $i<=31; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <select name="MM" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                                    <?php
                                    for($i=1; $i<=12; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <select name="YY" class="form-select bg-dark bg-opacity-20 text-white border-secondary">
                                    <?php
                                    for($i=2026; $i>=2018; $i--){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Payment Method Type -->
                        <div class="col-12">
                            <label class="form-label text-warning font-semibold text-xs tracking-wider uppercase">Payment Type</label>
                            <div class="d-flex gap-3 bg-dark bg-opacity-20 p-2 px-3 rounded border border-secondary" style="height: 42px; align-items: center;">
                                <div class="form-check mb-0">
                                    <input type="radio" name="money" id="neft" value="neft" class="form-check-input" checked>
                                    <label class="form-check-label text-sm cursor-pointer" for="neft">NEFT / NetBanking</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input type="radio" name="money" id="debit" value="debit card" class="form-check-input">
                                    <label class="form-check-label text-sm cursor-pointer" for="debit">Debit Card</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit buttons -->
                        <div class="col-12 d-flex gap-3 mt-4">
                            <button type="reset" class="btn btn-outline-secondary w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3">Clear</button>
                            <button type="submit" class="btn btn-warning w-50 py-2.5 text-uppercase tracking-wider font-semibold text-xs rounded-3 shadow">Submit Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
