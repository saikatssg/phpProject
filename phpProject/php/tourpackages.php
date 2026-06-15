<?php
    session_start();
    $logged = 0;
    $user_type = '';
    if (isset($_SESSION['c_id']) && $_SESSION['c_id'] != null) {
        $logged = 1;
        $user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'C';
    }

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $admin_message = '';
    $admin_error = '';

    // POST Action handlers for logged-in Administrators
    if ($logged && $user_type === 'A') {
        // 1. Create Tour Package
        if (isset($_POST['create_package'])) {
            $tp_name = mysqli_real_escape_string($conn, $_POST['tp_name']);
            $tp_dtls = mysqli_real_escape_string($conn, $_POST['tp_dtls']);
            $tp_cost = mysqli_real_escape_string($conn, $_POST['tp_cost']);
            $tp_dur = mysqli_real_escape_string($conn, $_POST['tp_dur']);
            $st_id = intval($_POST['st_id']);
            $p_id = intval($_POST['p_id']);

            $q = "INSERT INTO tourpackage_details (tp_name, tp_dtls, tp_cost, tp_dur, st_id, p_id) VALUES ('$tp_name', '$tp_dtls', '$tp_cost', '$tp_dur', $st_id, $p_id)";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Tour Package '$tp_name' created successfully!";
            } else {
                $admin_error = "Error creating package: " . mysqli_error($conn);
            }
        }

        // 2. Launch / Schedule Conduction
        if (isset($_POST['schedule_conduction'])) {
            $tp_id = intval($_POST['tp_id']);
            $strt_date = $_POST['strt_date'];
            
            // Format date robustly to DD/MM/YYYY
            $date_parsed = '';
            if (!empty($strt_date)) {
                if (preg_match('/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})$/', $strt_date, $matches)) {
                    $date_parsed = sprintf('%02d/%02d/%04d', $matches[3], $matches[2], $matches[1]);
                } elseif (preg_match('/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/', $strt_date, $matches)) {
                    $date_parsed = sprintf('%02d/%02d/%04d', $matches[1], $matches[2], $matches[3]);
                } else {
                    $timestamp = strtotime(str_replace('/', '-', $strt_date));
                    if ($timestamp !== false) {
                        $date_parsed = date('d/m/Y', $timestamp);
                    }
                }
            }

            if (!empty($date_parsed)) {
                $date_parsed_escaped = mysqli_real_escape_string($conn, $date_parsed);
                $q = "INSERT INTO tourconduction_details (tp_id, strt_date, tc_status) VALUES ($tp_id, '$date_parsed_escaped', 1)";
                if (mysqli_query($conn, $q)) {
                    $admin_message = "Tour conduction scheduled/renewed successfully!";
                } else {
                    $admin_error = "Error renewing tour conduction: " . mysqli_error($conn);
                }
            } else {
                $admin_error = "Invalid start date format.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tour Packages - PP travel ltd</title>
<!-- Bootstrap 5 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/modern_ui.css">

<style>
    body {
        padding-top: 150px !important;
        background-color: var(--color-bg-gray) !important;
    }
</style>
</head>
<body>

<?php
include "nav.php";
?>

<!-- Breadcrumb Page Header -->
<div class="luxury-page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold text-white mb-2" style="font-family: var(--font-serif) !important;">Tour Packages</h1>
        <div class="deco-divider justify-content-center">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="text-white opacity-75 font-serif" style="font-style: italic; font-size: 1.1rem;">Choose Your Perfect Holiday Plan</p>
    </div>
</div>

<div class="container my-5">
    <?php if($logged == 1): ?>
        <div class="text-end mb-4">
            <a href="logout.php" class="btn btn-outline-danger px-4 py-2 font-bold text-uppercase" style="border-radius: 4px; font-size: 12px; font-weight: 700;">Log Out</a>
        </div>
    <?php endif; ?>

    <!-- Success & Error Banners -->
    <?php if ($admin_message): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #10b981 !important;">
            <strong>Success!</strong> <?php echo $admin_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($admin_error): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #ef4444 !important;">
            <strong>Error!</strong> <?php echo $admin_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Admin: Create New Tour Package Section -->
    <?php if ($logged && $user_type === 'A'): ?>
        <div class="card shadow-sm border p-4 bg-white mb-5" style="border-radius: 16px; border-color: #e1e8ed !important;">
            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);"><span style="font-size:22px; vertical-align:middle; margin-right:8px;">🎒</span>Create New Tour Package</h4>
            <form method="post" action="tourpackages.php">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Package Name</label>
                        <input type="text" name="tp_name" required placeholder="e.g. DARJEELING-SIKKIM" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Cost (Rs.)</label>
                        <input type="text" name="tp_cost" required placeholder="e.g. Rs.15000" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Duration</label>
                        <input type="text" name="tp_dur" required placeholder="e.g. 6 Days 5 Nights" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Associated State</label>
                        <select name="st_id" required class="form-select">
                            <option value="">Select State</option>
                            <?php
                                $st_res = mysqli_query($conn, "SELECT st_id, st_name FROM state_details");
                                while($st = mysqli_fetch_assoc($st_res)) {
                                    echo "<option value='".$st['st_id']."'>".$st['st_name']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Associated Explorable Place</label>
                        <select name="p_id" required class="form-select">
                            <option value="">Select Explorable Place</option>
                            <?php
                                $p_res = mysqli_query($conn, "SELECT p_id, p_name FROM place_details");
                                while($p = mysqli_fetch_assoc($p_res)) {
                                    echo "<option value='".$p['p_id']."'>".$p['p_name']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-uppercase tracking-wider text-muted mb-1" style="font-size:10px;">Package Description Details</label>
                        <textarea name="tp_dtls" required placeholder="Describe the tour package itinerary, sightseeing, and accommodations..." class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="create_package" class="btn btn-luxury px-5">Create Package</button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Packages Grid -->
    <?php
    $query = "SELECT * FROM tourpackage_details ORDER BY tp_id DESC";
    if ($result = mysqli_query($conn, $query)) {
        echo '<div class="row g-4 justify-content-center">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-6 col-lg-4">
                <div class="package-card h-100 d-flex flex-column bg-white">
                    <!-- Image Container with floating badges -->
                    <div class="package-img-container">
                        <img src="../image/t_pkg/'.htmlspecialchars($row['tp_id']).'.jpg" alt="'.htmlspecialchars($row['tp_name']).'" onerror="this.src=\'../image/s1.jpg\'">
                        <div class="package-badge-price">'.htmlspecialchars($row['tp_cost']).'</div>
                        <div class="package-badge-duration">'.htmlspecialchars($row['tp_dur']).'</div>
                    </div>
                    
                    <!-- Content Block -->
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="package-rating">
                            ★★★★★
                        </div>
                        <h4 class="card-title text-primary fw-bold mb-2" style="font-family: var(--font-serif) !important; font-size: 1.35rem;">'.htmlspecialchars($row['tp_name']).'</h4>
                        <p class="card-text text-muted flex-grow-1" style="text-align: justify; font-size: 13px; line-height: 1.6;">'.htmlspecialchars($row['tp_dtls']).'</p>
                        
                        <!-- Checked Features -->
                        <ul class="package-features mb-3">
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Luxury Accommodations
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Guided Sightseeing Tours
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Professional Tour Conduction
                            </li>
                        </ul>
                        
                        <!-- CTA Buttons -->
                        <div class="d-flex gap-2 mt-auto">
                            <a href="touristspots_details.php?val='.htmlspecialchars($row['p_id']).'" class="btn btn-outline-secondary w-50 py-2 font-bold" style="font-size: 11px; text-transform: uppercase; border-color: #ccd6dd; color: var(--color-navy); text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;">Explore Spots</a>
                            <a href="tourdate_details.php?tp_id='.htmlspecialchars($row['tp_id']).'" class="btn btn-luxury w-50 py-2">Book Now</a>
                        </div>';

            // Admin: Quick Session Renewal / Conduction Launch Panel inline
            if ($logged && $user_type === 'A') {
                echo '
                        <div class="border-top mt-3 pt-3" style="border-color: #e9ecef !important;">
                            <span class="d-block fw-bold text-uppercase text-muted mb-2" style="font-size: 9px; letter-spacing:0.5px;">🚀 Launch Departure Session</span>
                            <form method="post" action="tourpackages.php" class="d-flex gap-2 align-items-center">
                                <input type="hidden" name="tp_id" value="'.intval($row['tp_id']).'">
                                <input type="date" name="strt_date" required class="form-control form-control-sm" style="font-size: 12px; height: 32px; margin-bottom: 0 !important;">
                                <button type="submit" name="schedule_conduction" class="btn btn-sm btn-luxury text-nowrap py-1 px-3" style="font-size: 11px;">Launch</button>
                            </form>
                        </div>';
            }

            echo '
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
        mysqli_free_result($result);
    }
    ?>  
</div>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
