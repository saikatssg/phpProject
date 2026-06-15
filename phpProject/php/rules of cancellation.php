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
<title>Rules of Cancellation - PP travel ltd</title>
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
    <div class="text-center mb-5">
        <h1 class="display-4 font-bold tracking-wider uppercase text-warning">Rules of Cancellation</h1> 
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

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary border-opacity-50 p-4 shadow animated-card">
                <div class="card-body">
                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>1. Passenger Cancellation:</strong> In case of cancellation of journey cancelled by the passenger, he or she is liable to pay cancellation charges as follows: if cancelled before 70 days of the commencement of the journey, INR 400 per head. Thereafter, cancellation before 30 days INR 750 per head. In case of cancellation within 30 days of the commencement of the journey, cancellation charges will be levied as per the following table in addition to the clause stated above:
                        <br><br>
                        • Between 29 days and 20 days — 20% of the total price + INR 750<br>
                        • Between 19 days and 10 days — 30% of the total price + INR 750<br>
                        • Between 09 days and 03 days — 40% of the total price + INR 750
                        <br><br>
                        No refund is admissible if a ticket is cancelled within 72 hours of the scheduled time of departure or thereafter.
                    </p>

                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>2. Surrendering Tickets:</strong> Cancellation will be acted upon only when the Advanced receipt / Ticket is surrendered at our office for cancellation, except in case of a passenger residing outside Kolkata, who may cancel his/her booking by letter or telegram only, which should be further confirmed within 5 days in person. But refund will be made after surrendering ticket / advanced receipt. Company will not be liable if such letter or telegram is not delivered in time.
                    </p>

                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>3. Company Cancellation:</strong> No amount deposited will be refunded in full, should the tour be cancelled by the company, except in the case of cancellation of the tour owing to natural calamities, strike/bandh or any other undesirable and abnormal situation, when the passengers have to pay compensation to the company @10% of the tour price.
                    </p>

                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>4. No Show Policies:</strong> No claim for any refund will be entertained when the passenger doesn't arrive at the station before departure of the train for which reservation has been made. In such cases, passengers may join next of subsequent station at their own cost.
                    </p>

                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>5. Validity Limitations:</strong> No claim will be entertained, if any amount found lying deposited with the company after 6 months from the date of commencement of the tour.
                    </p>

                    <p class="mb-3 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>6. Modifications:</strong> The company reserves the right to delete, change or modify the Rules as and when necessary.
                    </p>

                    <p class="mb-4 text-secondary" style="text-align: justify; line-height: 1.6;">
                        <strong>7. Govt ID Mandate:</strong> As per Govt. Rules, passengers travelling with us are requested to carry a PHOTO IDENTITY CARD with him/her.
                    </p>

                    <div class="text-center">
                        <a href="cancellation_details.php" class="btn btn-warning px-5 py-3 fw-bold text-uppercase tracking-wider rounded-pill shadow">File Cancellation Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
