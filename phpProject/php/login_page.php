<?php
    session_start();
    $logged = 0;
    if (isset($_SESSION['c_id']) && $_SESSION['c_id'] != null) {
        $logged = 1;
        header("Location: home.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login - PP travel ltd</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/modern_ui.css">
    
    <style>
        body {
            background: linear-gradient(rgba(12, 35, 64, 0.3), rgba(12, 35, 64, 0.4)), url(../image/slider-one.jpg) center/cover fixed no-repeat !important;
            padding-top: 150px !important;
            background-size: cover !important;
            background-position: bottom !important;
        }
        .login-container {
            min-height: calc(100vh - 150px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            border-radius: 6px !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25) !important;
            color: var(--color-navy);
            width: 100%;
            max-width: 480px;
            padding: 40px !important;
            box-sizing: border-box !important;
        }
    </style>
</head>

<body>
    <!-- Dual-Row Header -->
    <?php include "nav2.php"; ?>

    <div class="login-container">
        <div class="login-card">
            <h3 class="text-center mb-4 uppercase fw-bold" style="color: var(--color-navy); font-family: var(--font-serif); letter-spacing: 1px;">Portal Login</h3>
            
            <form method="post" action="login_form.php">
                <div class="mb-4">
                    <label class="form-label font-bold text-xs uppercase" style="color: var(--color-navy); margin-bottom: 8px; display: block;">User Type</label>
                    <div class="d-flex justify-content-around bg-light p-3 rounded border" style="border-color: #ccd6dd !important;">
                        <div class="form-check">
                            <input type="radio" name="user_type" id="admin" value="A" class="form-check-input" required>
                            <label class="form-check-label text-dark text-sm cursor-pointer" for="admin">Admin</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="user_type" id="customer" value="C" class="form-check-input" checked required>
                            <label class="form-check-label text-dark text-sm cursor-pointer" for="customer">Customer</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="user_type" id="employee" value="E" class="form-check-input" required>
                            <label class="form-check-label text-dark text-sm cursor-pointer" for="employee">Employee</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="user" class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Username / Email</label>
                    <input type="text" class="form-control bg-white text-dark border-secondary py-2" id="user" name="user" placeholder="Email-id" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>
                
                <div class="mb-4">
                    <label for="pass" class="form-label font-bold text-xs uppercase" style="color: var(--color-navy);">Password</label>
                    <input type="password" class="form-control bg-white text-dark border-secondary py-2" id="pass" name="pass" placeholder="Password" required style="border-color: #ccd6dd !important; color: #2c3e50 !important;">
                </div>
                
                <button type="submit" class="btn btn-luxury w-100 py-3 fw-bold text-uppercase tracking-wide mb-4 shadow">Sign In</button>
            </form>

            <div class="text-center mt-3 pt-3 border-top border-secondary border-opacity-25">
                <p class="mb-2 text-muted text-sm border-0 bg-transparent p-0">New to PP Travels?</p>
                <a href="cust_details.php" class="btn btn-outline-secondary px-4 py-2 text-uppercase tracking-wider font-semibold text-xs rounded-pill" style="color: var(--color-navy); border-color: var(--color-navy); text-decoration: none;">Create Account</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
