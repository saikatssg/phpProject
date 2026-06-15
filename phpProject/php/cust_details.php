<?php
    session_start();
    $logged = 0;
    if (isset($_SESSION['c_id']) && $_SESSION['c_id'] != null) {
        $logged = 1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Registration - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/modern_ui.css">

<style>
    body {
        background: linear-gradient(rgba(12, 35, 64, 0.35), rgba(12, 35, 64, 0.45)), url(../image/andaman3.jpg) center/cover fixed no-repeat !important;
        padding-top: 150px !important;
    }
    
    .form-card {
        background: rgba(255, 255, 255, 0.67) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
        border-radius: 12px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25) !important;
        color: var(--color-navy) !important;
        margin-bottom: 50px;
    }

    .form-card h2 {
        font-family: var(--font-serif) !important;
        color: var(--color-navy) !important;
        font-weight: 800 !important;
        letter-spacing: 1.5px !important;
    }

    .form-card label {
        color: var(--color-navy) !important;
        font-weight: 700 !important;
        font-size: 11.5px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 6px !important;
    }

    .form-card input[type="text"],
    .form-card input[type="password"],
    .form-card input[type="email"],
    .form-card select,
    .form-card textarea {
        background: #ffffff !important;
        border: 1px solid #ccd6dd !important;
        border-radius: 6px !important;
        color: var(--color-text-dark) !important;
        font-size: 13.5px !important;
        padding: 10px 14px !important;
        transition: all 0.25s ease-in-out !important;
        margin-bottom: 0 !important; /* Reset default margin */
    }

    .form-card input:focus,
    .form-card select:focus,
    .form-card textarea:focus {
        border-color: var(--color-gold) !important;
        box-shadow: 0 0 0 3px rgba(223, 169, 32, 0.15) !important;
    }

    .gender-box {
        background-color: #f8f9fa !important;
        border: 1px solid #ccd6dd !important;
        border-radius: 6px !important;
        height: 42px;
        display: flex;
        align-items: center;
        padding: 0 16px;
    }

    .gender-box .form-check-label {
        color: var(--color-text-dark) !important;
        font-weight: 500 !important;
        font-size: 13.5px !important;
        text-transform: none !important;
        margin-bottom: 0 !important;
        cursor: pointer;
    }

    .gender-box .form-check-input {
        cursor: pointer;
    }

    .btn-submit-reg {
        background-color: var(--color-gold) !important;
        color: var(--color-navy) !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 12px 24px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 10px rgba(223, 169, 32, 0.2) !important;
    }

    .btn-submit-reg:hover {
        background-color: var(--color-navy) !important;
        color: #ffffff !important;
        box-shadow: 0 6px 14px rgba(12, 35, 64, 0.25) !important;
        transform: translateY(-1px);
    }

    .btn-clear-reg {
        background-color: transparent !important;
        border: 1px solid #ccd6dd !important;
        color: var(--color-text-muted) !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        border-radius: 6px !important;
        padding: 12px 24px !important;
        transition: all 0.2s ease !important;
    }

    .btn-clear-reg:hover {
        border-color: #999999 !important;
        color: var(--color-text-dark) !important;
        background-color: #f8f9fa !important;
    }
</style>
</head>

<body>
<?php include "nav.php"; ?>

<div class="container my-5" style="max-width: 800px;">
    <div class="form-card p-5">
        <h2 class="text-center fw-bold text-uppercase mb-2">Customer Registration</h2>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-center text-muted font-serif mb-4" style="font-style: italic; font-size: 14px; border: none; background: transparent; padding: 0;">Create your travel portal account in seconds</p>
        
        <form action="customer_details.php" method="post" onsubmit="return validateForm();">
            <div class="row g-4">
                <!-- Name -->
                <div class="col-12">
                    <label for="m_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="m_name" name="m_name" placeholder="Enter your full name" required pattern="^[A-Za-z\s]{3,50}$" title="Name should be between 3 and 50 alphabetic characters">
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label for="addr" class="form-label">Address</label>
                    <textarea class="form-control" id="addr" name="addr" rows="3" placeholder="Enter your address" required></textarea>
                </div>

                <!-- Mobile -->
                <div class="col-md-6">
                    <label for="m_mob" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="m_mob" name="m_mob" placeholder="e.g. 9876543210" required pattern="^[6-9]\d{9}$" title="Mobile number must be a 10-digit number starting with 6, 7, 8, or 9">
                </div>

                <!-- Gender -->
                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <div class="gender-box d-flex gap-4">
                        <div class="form-check mb-0">
                            <input type="radio" name="gen" id="male" value="male" class="form-check-input" checked>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check mb-0">
                            <input type="radio" name="gen" id="female" value="female" class="form-check-input">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail Id</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="e.g. name@example.com" required>
                </div>

                <!-- DOB -->
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <div class="d-flex gap-2">
                        <select name="DD" class="form-select" required>
                            <option value="">Day</option>
                            <?php
                            for($i=1; $i<=31; $i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                        <select name="MM" class="form-select" required>
                            <option value="">Month</option>
                            <?php
                            $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                            for($i=1; $i<=12; $i++){
                                echo "<option value='$i'>".$months[$i-1]."</option>";
                            }
                            ?>
                        </select>
                        <select name="YY" class="form-select" required>
                            <option value="">Year</option>
                            <?php
                            $currentYear = date("Y");
                            for($i=$currentYear - 5; $i>=$currentYear - 100; $i--){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <label for="pswd" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pswd" name="pswd" placeholder="Min. 6 characters" required minlength="6">
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <label for="cpswd" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="cpswd" name="cpswd" placeholder="Re-enter password" required minlength="6">
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex gap-3 mt-4">
                    <button type="reset" class="btn btn-clear-reg w-50">Clear</button>
                    <button type="submit" class="btn btn-submit-reg w-50">Register Account</button>
                </div>
            </div>
        </form>

        <div class="text-center mt-4 pt-3 border-top border-secondary border-opacity-10">
            <span class="text-muted text-sm">Already have an account? </span>
            <a href="login_page.php" class="text-decoration-none fw-bold" style="color: var(--color-navy) !important;">Sign In Here</a>
        </div>
    </div>
</div>

<!-- Form Validation Script -->
<script type="text/javascript">
function validateForm() {
    var name = document.getElementById("m_name").value.trim();
    var mobile = document.getElementById("m_mob").value.trim();
    var email = document.getElementById("email").value.trim();
    var pswd = document.getElementById("pswd").value;
    var cpswd = document.getElementById("cpswd").value;

    // Validate Name: only letters and spaces, at least 3 characters
    var namePattern = /^[A-Za-z\s]{3,50}$/;
    if (!namePattern.test(name)) {
        alert("Please enter a valid Full Name (between 3 and 50 alphabetical characters).");
        return false;
    }

    // Validate Mobile: 10 digits starting with 6-9
    var mobPattern = /^[6-9]\d{9}$/;
    if (!mobPattern.test(mobile)) {
        alert("Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.");
        return false;
    }

    // Validate Email
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Validate Password match
    if (pswd !== cpswd) {
        alert("Passwords do not match. Please verify.");
        return false;
    }

    // Validate password length
    if (pswd.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    // Validate D.O.B date sanity
    var ddVal = document.getElementsByName("DD")[0].value;
    var mmVal = document.getElementsByName("MM")[0].value;
    var yyVal = document.getElementsByName("YY")[0].value;

    if (!ddVal || !mmVal || !yyVal) {
        alert("Please select your complete Date of Birth.");
        return false;
    }

    var dd = parseInt(ddVal);
    var mm = parseInt(mmVal);
    var yy = parseInt(yyVal);

    var dateObj = new Date(yy, mm - 1, dd);
    if (dateObj.getFullYear() !== yy || dateObj.getMonth() !== mm - 1 || dateObj.getDate() !== dd) {
        alert("Please select a valid Date of Birth.");
        return false;
    }

    return true;
}
</script>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
