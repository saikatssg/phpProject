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

    // POST Request Handlers for Admin actions
    $admin_message = '';
    $admin_error = '';
    if ($logged && $user_type === 'A') {
        // Create Tour Package
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
        
        // Register Hotel
        if (isset($_POST['register_hotel'])) {
            $h_name = mysqli_real_escape_string($conn, $_POST['h_name']);
            $h_loc = mysqli_real_escape_string($conn, $_POST['h_loc']);
            $h_city = mysqli_real_escape_string($conn, $_POST['h_city']);
            $st_id = intval($_POST['st_id']);
            $h_rate = mysqli_real_escape_string($conn, $_POST['h_rate']);
            $h_desc = mysqli_real_escape_string($conn, $_POST['h_desc']);
            $ac_rm = intval($_POST['ac_rm']);
            $nac_rm = intval($_POST['nac_rm']);
            $avlac_rm = intval($_POST['avlac_rm']);
            $avlnac_rm = intval($_POST['avlnac_rm']);

            $q = "INSERT INTO hotel_details (h_name, h_loc, h_city, st_id, h_rate, h_desc, ac_rm, nac_rm, avlac_rm, avlnac_rm) VALUES ('$h_name', '$h_loc', '$h_city', $st_id, '$h_rate', '$h_desc', $ac_rm, $nac_rm, $avlac_rm, $avlnac_rm)";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Hotel '$h_name' registered successfully!";
            } else {
                $admin_error = "Error registering hotel: " . mysqli_error($conn);
            }
        }

        // Upgrade Package (Edit)
        if (isset($_POST['upgrade_package'])) {
            $tp_id = intval($_POST['tp_id']);
            $tp_cost = mysqli_real_escape_string($conn, $_POST['tp_cost']);
            $tp_dtls = mysqli_real_escape_string($conn, $_POST['tp_dtls']);
            $tp_dur = mysqli_real_escape_string($conn, $_POST['tp_dur']);

            $q = "UPDATE tourpackage_details SET tp_cost='$tp_cost', tp_dtls='$tp_dtls', tp_dur='$tp_dur' WHERE tp_id=$tp_id";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Package upgraded successfully!";
            } else {
                $admin_error = "Error upgrading package: " . mysqli_error($conn);
            }
        }

        // Upgrade Hotel (Edit)
        if (isset($_POST['upgrade_hotel'])) {
            $h_id = intval($_POST['h_id']);
            $h_rate = mysqli_real_escape_string($conn, $_POST['h_rate']);
            $h_desc = mysqli_real_escape_string($conn, $_POST['h_desc']);
            $avlac_rm = intval($_POST['avlac_rm']);
            $avlnac_rm = intval($_POST['avlnac_rm']);

            $q = "UPDATE hotel_details SET h_rate='$h_rate', h_desc='$h_desc', avlac_rm=$avlac_rm, avlnac_rm=$avlnac_rm WHERE h_id=$h_id";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Hotel registration details upgraded successfully!";
            } else {
                $admin_error = "Error upgrading hotel: " . mysqli_error($conn);
            }
        }

        // Confirm Payment Action
        if (isset($_POST['confirm_payment'])) {
            $pmt_id = intval($_POST['pmt_id']);
            $q = "UPDATE payment_details SET pmt_status='Confirm' WHERE pmt_id=$pmt_id";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Payment ID #$pmt_id confirmed successfully!";
            } else {
                $admin_error = "Error confirming payment: " . mysqli_error($conn);
            }
        }

        // Schedule Tour Conduction
        if (isset($_POST['schedule_conduction'])) {
            $tp_id = intval($_POST['tp_id']);
            $strt_date = $_POST['strt_date'];
            
            // Format date to DD/MM/YYYY robustly
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
            
            $date_parsed_escaped = mysqli_real_escape_string($conn, $date_parsed);
            $q = "INSERT INTO tourconduction_details (tp_id, strt_date, tc_status) VALUES ($tp_id, '$date_parsed_escaped', 1)";
            if (mysqli_query($conn, $q)) {
                $admin_message = "New tour conduction scheduled successfully!";
            } else {
                $admin_error = "Error scheduling tour conduction: " . mysqli_error($conn);
            }
        }

        // Toggle Conduction Status
        if (isset($_POST['toggle_conduction_status'])) {
            $tc_id = intval($_POST['tc_id']);
            $current_status = intval($_POST['current_status']);
            $new_status = ($current_status === 1) ? 2 : 1; // Toggle between 1 (Active/Scheduled) and 2 (Completed)
            
            $q = "UPDATE tourconduction_details SET tc_status = $new_status WHERE tc_id = $tc_id";
            if (mysqli_query($conn, $q)) {
                $admin_message = "Conduction status updated successfully!";
            } else {
                $admin_error = "Error updating conduction status: " . mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PP travel ltd</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/home_modern_ui.css">
    <style>
        body {
            background-color: var(--color-bg-light) !important;
            padding-top: 170px !important;
        }
        body.admin-body {
            padding-top: 0 !important;
            overflow: hidden !important;
            height: 100vh !important;
            width: 100vw !important;
        }
        .card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            border-color: var(--color-gold) !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }
    </style>
</head>

<body<?php echo ($logged && $user_type === 'A') ? ' class="admin-body"' : ''; ?>>
    <!-- Header Navigation -->
    <?php if (!$logged || $user_type !== 'A'): ?>
        <?php include "nav2.php"; ?>
    <?php endif; ?>

    <?php if ($logged && $user_type === 'A'): ?>
        <!-- ======================================================================
             ADMIN DASHBOARD INTERFACE
             ====================================================================== -->
        <div class="admin-layout">
            
            <!-- Sidebar -->
            <div class="admin-sidebar">
                <div class="admin-sidebar-header d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center text-white rounded-circle shadow-sm" style="width: 38px; height: 38px; background-color: var(--color-cyan);">
                        <span style="font-size: 18px;">✈️</span>
                    </div>
                    <div>
                        <h5 class="m-0 fw-bold" style="color: var(--color-navy); font-family: var(--font-sans) !important; font-size: 16px; letter-spacing: 0.5px;">Advantgo</h5>
                        <span class="text-uppercase" style="color: #5e6d7c; font-size: 8px; font-weight: 700; letter-spacing: 1.5px; display: block; margin-top: -2px;">Admin Portal</span>
                    </div>
                </div>
                <div class="admin-sidebar-menu">
                    <button class="admin-sidebar-btn active" data-target="overview">📊 Dashboard</button>
                    <button class="admin-sidebar-btn" data-target="create-pkg">🎒 Create Package</button>
                    <button class="admin-sidebar-btn" data-target="conduct-tour">🚌 Conduct Tour</button>
                    <button class="admin-sidebar-btn" data-target="reg-hotel">🏨 Register Hotel</button>
                    <button class="admin-sidebar-btn" data-target="upgrades">🔧 Upgrades & Cost</button>
                    <button class="admin-sidebar-btn" data-target="users">👥 User Directory</button>
                    <button class="admin-sidebar-btn" data-target="payments">💳 Orders / Verification</button>
                    <button class="admin-sidebar-btn" data-target="cancellations">❌ Cancellations</button>
                    <button class="admin-sidebar-btn" data-target="reports">📈 Tour Reports</button>
                </div>
                <div class="p-3 border-top" style="border-color: #f0f4f7 !important;">
                    <a href="logout.php" class="admin-sidebar-btn text-danger d-flex align-items-center gap-2" style="text-decoration: none; color: #ef4444 !important;">
                        <span>🚪</span> Log Out
                    </a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="admin-main">
                <div class="admin-topbar">
                    <div class="d-flex align-items-center gap-4">
                        <h4 class="m-0 fw-bold" style="font-family: var(--font-sans) !important; color: var(--color-navy); font-size: 20px;">Dashboard</h4>
                        <div class="position-relative d-none d-md-block">
                            <span class="position-absolute translate-middle-y top-50 start-0 ps-3 text-muted" style="font-size: 12px; margin-top: -6px;">🔍</span>
                            <input type="text" placeholder="Search here..." style="width: 240px; height: 38px; border-radius: 20px; border: 1px solid #ccd6dd; padding-left: 36px; font-size: 13px; margin: 0 !important; background-color: #f7f9fb !important;">
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3 me-3 text-muted" style="font-size: 16px;">
                            <span style="cursor: pointer; position: relative;">🔔<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 6px; height: 6px;"></span></span>
                            <span style="cursor: pointer;">✉️</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 p-1 pe-3 rounded-pill" style="background-color: #f7f9fb; border: 1px solid #e1e8ed;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 32px; height: 32px; background-color: var(--color-navy); font-size: 0.9rem; font-family: var(--font-sans);">
                                <?php echo strtoupper(substr($_SESSION['c_name'], 0, 1)); ?>
                            </div>
                            <span class="fw-bold" style="font-size: 12px; color: var(--color-navy);"><?php echo $_SESSION['c_name']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="admin-content-scroll">
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

                    <!-- OVERVIEW PANEL -->
                    <div id="overview" class="tab-panel active">
                        <?php
                            $res_cust = mysqli_query($conn, "SELECT COUNT(*) FROM customer_details");
                            $tot_cust = mysqli_fetch_row($res_cust)[0];
                            $res_cans = mysqli_query($conn, "SELECT COUNT(*) FROM cancellation_details");
                            $tot_cans = mysqli_fetch_row($res_cans)[0];
                            $res_pending = mysqli_query($conn, "SELECT COUNT(*) FROM payment_details WHERE pmt_status != 'Confirm' OR pmt_status IS NULL");
                            $tot_pending = mysqli_fetch_row($res_pending)[0];
                            $res_pkgs_cnt = mysqli_query($conn, "SELECT COUNT(*) FROM tourpackage_details");
                            $tot_pkgs = mysqli_fetch_row($res_pkgs_cnt)[0];
                        ?>
                        
                        <div class="row g-4">
                            <!-- Left Column: Core content (Stats, Trending places, Performance charts) -->
                            <div class="col-lg-8">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="admin-widget-card">
                                            <span class="text-uppercase tracking-wider opacity-75 d-block mb-1 text-muted" style="font-size: 10px; font-weight: 700;">Total Visit</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <h3 class="fw-bold m-0 text-navy" style="font-family: var(--font-sans) !important; font-size: 20px; color: var(--color-navy);"><?php echo $tot_cust; ?></h3>
                                                <span class="text-success" style="font-size: 10px; font-weight: 700;">▲ 3.5%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="admin-widget-card">
                                            <span class="text-uppercase tracking-wider opacity-75 d-block mb-1 text-muted" style="font-size: 10px; font-weight: 700;">Cancel Travel</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <h3 class="fw-bold m-0 text-navy" style="font-family: var(--font-sans) !important; font-size: 20px; color: var(--color-navy);"><?php echo $tot_cans; ?></h3>
                                                <span class="text-danger" style="font-size: 10px; font-weight: 700;">▼ 1.2%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="admin-widget-card">
                                            <span class="text-uppercase tracking-wider opacity-75 d-block mb-1 text-muted" style="font-size: 10px; font-weight: 700;">In Queue</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <h3 class="fw-bold m-0 text-navy" style="font-family: var(--font-sans) !important; font-size: 20px; color: var(--color-navy);"><?php echo $tot_pending; ?></h3>
                                                <span class="text-success" style="font-size: 10px; font-weight: 700;">▲ 2.4%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="admin-widget-card">
                                            <span class="text-uppercase tracking-wider opacity-75 d-block mb-1 text-muted" style="font-size: 10px; font-weight: 700;">Interested Places</span>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <h3 class="fw-bold m-0 text-navy" style="font-family: var(--font-sans) !important; font-size: 20px; color: var(--color-navy);"><?php echo $tot_pkgs; ?></h3>
                                                <span class="text-success" style="font-size: 10px; font-weight: 700;">▲ 4.8%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm border p-4 bg-white mb-4" style="border-radius: 16px; border-color: #e1e8ed !important;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold text-navy m-0" style="font-family: var(--font-sans) !important; font-size: 15px;">Trending Places</h5>
                                        <span class="text-muted" style="font-size: 11px; cursor: pointer;" onclick="localStorage.setItem('activeAdminTab', 'upgrades'); window.location.reload();">See All</span>
                                    </div>
                                    <div class="trending-places-container">
                                        <?php
                                            $trending_pkgs = mysqli_query($conn, "SELECT tp.tp_name, tp.tp_cost, s.st_name FROM tourpackage_details tp LEFT JOIN state_details s ON tp.st_id=s.st_id LIMIT 6");
                                            $img_arr = ['slider-one.jpg', 'andaman3.jpg', 'andaman1.jpg', 'sample3.jpg', 'sample4.jpg', 'sample5.jpg'];
                                            $idx = 0;
                                            while($tp = mysqli_fetch_assoc($trending_pkgs)):
                                                $img_name = $img_arr[$idx % count($img_arr)];
                                                $idx++;
                                        ?>
                                            <div class="trending-place-card">
                                                <img src="../image/<?php echo $img_name; ?>" class="trending-place-img" alt="Place image">
                                                <div class="trending-place-info">
                                                    <h6 class="trending-place-name" title="<?php echo $tp['tp_name']; ?>"><?php echo $tp['tp_name']; ?></h6>
                                                    <p class="trending-place-location">📍 <?php echo $tp['st_name']; ?></p>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <span class="badge bg-light text-navy fw-bold" style="font-size: 10px; border: 1px solid #e1e8ed;"><?php echo $tp['tp_cost']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- Column 1: Main Street Resort Details -->
                                    <div class="col-md-4">
                                        <?php
                                            $first_hotel_res = mysqli_query($conn, "SELECT h_name, h_city, h_desc FROM hotel_details LIMIT 1");
                                            $fh = mysqli_fetch_assoc($first_hotel_res);
                                            $hotel_name = $fh ? $fh['h_name'] : "Main Street Resort";
                                            $hotel_city = $fh ? $fh['h_city'] : "Shimla";
                                            $hotel_desc = $fh ? substr($fh['h_desc'], 0, 75) . '...' : "Beautiful resort with panoramic mountain views and luxury accommodations.";
                                        ?>
                                        <div class="card shadow-sm border p-3 bg-white h-100" style="border-radius: 16px; border-color: #e1e8ed !important;">
                                            <h6 class="fw-bold text-navy mb-1" style="font-family: var(--font-sans) !important; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo $hotel_name; ?>"><?php echo $hotel_name; ?></h6>
                                            <span class="text-muted text-uppercase d-block mb-3" style="font-size: 9px; font-weight: 700; letter-spacing: 0.5px;">Virtual Tour</span>
                                            <div class="position-relative rounded overflow-hidden mb-3" style="height: 100px;">
                                                <img src="../image/andaman3.jpg" alt="Resort image" style="width: 100%; height: 100%; object-fit: cover;">
                                                <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-white d-flex align-items-center justify-content-center shadow" style="width: 32px; height: 32px; cursor: pointer; opacity: 0.9;">
                                                    <span style="font-size: 12px; margin-left: 2px;">▶️</span>
                                                </div>
                                            </div>
                                            <p class="text-muted m-0" style="font-size: 11px; line-height: 1.4; height: 46px; overflow: hidden;"><?php echo $hotel_desc; ?></p>
                                            <div class="mt-3 text-end">
                                                <a href="#" onclick="localStorage.setItem('activeAdminTab', 'upgrades'); window.location.reload();" class="text-decoration-none text-navy fw-bold" style="font-size: 11px;">Learn More ➔</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Column 2: Monthly Expenses History (Bar Chart) -->
                                    <div class="col-md-4">
                                        <?php
                                            $chart_data = mysqli_query($conn, "SELECT DATE_FORMAT(pmt_date, '%b') as m_lbl, COUNT(*) as b_cnt FROM payment_details WHERE pmt_status='Confirm' AND pmt_date IS NOT NULL AND pmt_date != '0000-00-00' GROUP BY m_lbl ORDER BY MIN(pmt_date) DESC LIMIT 6");
                                            $months = [];
                                            $booking_counts = [];
                                            $max_count = 1;
                                            if ($chart_data) {
                                                while($row = mysqli_fetch_assoc($chart_data)) {
                                                    $months[] = $row['m_lbl'];
                                                    $booking_counts[] = intval($row['b_cnt']);
                                                    if (intval($row['b_cnt']) > $max_count) {
                                                        $max_count = intval($row['b_cnt']);
                                                    }
                                                }
                                            }
                                            if (empty($months)) {
                                                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                                                $booking_counts = [5, 12, 18, 14, 25, 20];
                                                $max_count = 25;
                                            } else {
                                                $months = array_reverse($months);
                                                $booking_counts = array_reverse($booking_counts);
                                            }
                                        ?>
                                        <div class="card shadow-sm border p-3 bg-white h-100" style="border-radius: 16px; border-color: #e1e8ed !important;">
                                            <h6 class="fw-bold text-navy mb-1" style="font-family: var(--font-sans) !important; font-size: 13px;">Monthly Expenses</h6>
                                            <span class="text-muted text-uppercase d-block mb-3" style="font-size: 9px; font-weight: 700; letter-spacing: 0.5px;">History</span>
                                            
                                            <div class="bar-chart-container" style="height: 120px; padding: 5px 10px; border-bottom: none; margin-bottom: 0;">
                                                <?php foreach($months as $i => $m): 
                                                    $h_pct = ($booking_counts[$i] / $max_count) * 100;
                                                ?>
                                                    <div class="bar-chart-bar-wrapper">
                                                        <div class="bar-chart-bar" style="height: <?php echo max(15, $h_pct * 0.9); ?>px; width: 14px;" title="<?php echo $booking_counts[$i]; ?> Bookings"></div>
                                                        <span class="bar-chart-label" style="font-size: 8px;"><?php echo $m; ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <p class="text-muted text-center m-0" style="font-size: 9px; line-height: 1.2; margin-top: 10px !important;">Confirmed transactions overview.</p>
                                        </div>
                                    </div>

                                    <!-- Column 3: Tourist Visit (Line Chart) -->
                                    <div class="col-md-4">
                                        <div class="card shadow-sm border p-3 bg-white h-100" style="border-radius: 16px; border-color: #e1e8ed !important;">
                                            <h6 class="fw-bold text-navy mb-1" style="font-family: var(--font-sans) !important; font-size: 13px;">Tourist Visit</h6>
                                            <span class="text-muted text-uppercase d-block mb-3" style="font-size: 9px; font-weight: 700; letter-spacing: 0.5px;">Statistics</span>
                                            
                                            <div class="position-relative" style="height: 120px; width: 100%;">
                                                <svg viewBox="0 0 100 50" class="w-100 h-100">
                                                    <!-- Grid Lines -->
                                                    <line x1="0" y1="10" x2="100" y2="10" stroke="#f0f4f7" stroke-width="0.5"/>
                                                    <line x1="0" y1="25" x2="100" y2="25" stroke="#f0f4f7" stroke-width="0.5"/>
                                                    <line x1="0" y1="40" x2="100" y2="40" stroke="#f0f4f7" stroke-width="0.5"/>
                                                    
                                                    <!-- Path Line 1: Highly Satisfied (Cyan) -->
                                                    <path d="M 0 40 Q 20 15, 40 30 T 80 10 T 100 20" fill="none" stroke="#00bef0" stroke-width="2"/>
                                                    <circle cx="80" cy="10" r="2" fill="#00bef0"/>
                                                    <circle cx="40" cy="30" r="2" fill="#00bef0"/>
                                                    
                                                    <!-- Path Line 2: Mid-Scale (Blue) -->
                                                    <path d="M 0 35 Q 25 38, 50 15 T 100 25" fill="none" stroke="#0072ff" stroke-width="2"/>
                                                    <circle cx="50" cy="15" r="2" fill="#0072ff"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center gap-2 mt-2" style="font-size: 8px; white-space: nowrap;">
                                                <span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="width: 5px; height: 5px; background-color: #00bef0; display: inline-block;"></span> Highly Sat.</span>
                                                <span class="d-flex align-items-center gap-1"><span class="rounded-circle" style="width: 5px; height: 5px; background-color: #0072ff; display: inline-block;"></span> Mid-Scale</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Inside content sidebar (Calendar, Recent Bookings) -->
                            <div class="col-lg-4">
                                <div class="calendar-widget-card mb-4">
                                    <div class="calendar-header">
                                        <span>Trip Listing this Month</span>
                                        <span style="color: var(--color-cyan); cursor: pointer;">June 2026</span>
                                    </div>
                                    <div class="calendar-grid">
                                        <span class="calendar-day-label">Su</span>
                                        <span class="calendar-day-label">Mo</span>
                                        <span class="calendar-day-label">Tu</span>
                                        <span class="calendar-day-label">We</span>
                                        <span class="calendar-day-label">Th</span>
                                        <span class="calendar-day-label">Fr</span>
                                        <span class="calendar-day-label">Sa</span>
                                        
                                        <!-- Days starting June 2026 (June 1st is Monday, day index 2 in grid if starts on Sunday) -->
                                        <?php
                                        for($i = 1; $i <= 30 + 1; $i++) {
                                            if ($i <= 1) {
                                                echo '<span></span>';
                                            } else {
                                                $day_num = $i - 1;
                                                $class = 'calendar-day';
                                                if ($day_num === 15) $class .= ' active';
                                                if ($day_num === 15) $class .= ' today';
                                                echo '<span class="'.$class.'">'.$day_num.'</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="card shadow-sm border p-4 bg-white" style="border-radius: 16px; border-color: #e1e8ed !important;">
                                    <h5 class="fw-bold text-navy mb-3" style="font-family: var(--font-sans) !important; font-size: 14px;">Upcoming Visitors</h5>
                                    <div class="d-flex flex-column">
                                        <?php 
                                            $recent_bks = mysqli_query($conn, "SELECT b.bk_id, b.bk_date, c.c_name FROM booking_details b JOIN customer_details c ON b.c_id=c.c_id ORDER BY b.bk_id DESC LIMIT 4");
                                            if(mysqli_num_rows($recent_bks) === 0):
                                        ?>
                                            <p class="text-muted text-center py-3 m-0" style="font-size: 12px;">No recent visitors registered.</p>
                                        <?php
                                            else:
                                                while($rb = mysqli_fetch_assoc($recent_bks)):
                                                    $initial = strtoupper(substr($rb['c_name'], 0, 1));
                                        ?>
                                            <div class="upcoming-visitor-item">
                                                <div class="visitor-avatar">
                                                    <?php echo $initial; ?>
                                                </div>
                                                <div class="visitor-info">
                                                    <h6 class="visitor-name"><?php echo $rb['c_name']; ?></h6>
                                                    <p class="visitor-date"><?php echo date('d M, Y', strtotime($rb['bk_date'])); ?></p>
                                                </div>
                                                <div>
                                                    <button class="btn-visitor-details" onclick="localStorage.setItem('activeAdminTab', 'payments'); window.location.reload();">Details</button>
                                                </div>
                                            </div>
                                        <?php 
                                                endwhile;
                                            endif; 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CREATE TOUR PACKAGE PANEL -->
                    <div id="create-pkg" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Create New Tour Package</h4>
                            <form method="post" action="home.php">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Package Name</label>
                                        <input type="text" name="tp_name" required placeholder="e.g. DARJEELING-SIKKIM">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Cost (Rs.)</label>
                                        <input type="text" name="tp_cost" required placeholder="e.g. Rs.15000">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Duration</label>
                                        <input type="text" name="tp_dur" required placeholder="e.g. 6 Days 5 Nights">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Associated State</label>
                                        <select name="st_id" required>
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
                                        <label class="form-label-admin">Associated Explorable Place</label>
                                        <select name="p_id" required>
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
                                        <label class="form-label-admin">Package Description Details</label>
                                        <textarea name="tp_dtls" required placeholder="Describe the tour package itinerary, sightseeing, and accommodations..."></textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" name="create_package" class="btn btn-luxury px-5 mt-3">Create Package</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CONDUCT / SCHEDULE TOUR PANEL -->
                    <div id="conduct-tour" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-radius: 16px; border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Conduct / Schedule Tour Conduction</h4>
                            <form method="post" action="home.php">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Select Tour Package</label>
                                        <select name="tp_id" required>
                                            <option value="">Select Package</option>
                                            <?php
                                                $pkgs_res = mysqli_query($conn, "SELECT tp_id, tp_name FROM tourpackage_details");
                                                while($pkg = mysqli_fetch_assoc($pkgs_res)) {
                                                    echo "<option value='".$pkg['tp_id']."'>".$pkg['tp_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Tour Departure / Start Date</label>
                                        <input type="date" name="strt_date" required>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" name="schedule_conduction" class="btn btn-luxury px-5 mt-3">Schedule Tour Conduction</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Quick Session Renewal Panel -->
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-radius: 16px; border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-1" style="color: var(--color-navy); font-family: var(--font-serif);">Quick Renew Package for Next Session</h4>
                            <p class="text-muted mb-4" style="font-size: 12px;">Schedule a new departure date for any existing package directly.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>Package ID</th>
                                            <th>Package Name</th>
                                            <th>Cost</th>
                                            <th>Duration</th>
                                            <th style="width: 320px;">Schedule Next Session Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $pkgs_all = mysqli_query($conn, "SELECT * FROM tourpackage_details ORDER BY tp_id DESC");
                                            while($pkg = mysqli_fetch_assoc($pkgs_all)):
                                        ?>
                                        <tr>
                                            <td>#PKG-<?php echo $pkg['tp_id']; ?></td>
                                            <td class="fw-bold"><?php echo $pkg['tp_name']; ?></td>
                                            <td class="text-success fw-bold"><?php echo $pkg['tp_cost']; ?></td>
                                            <td><?php echo $pkg['tp_dur']; ?></td>
                                            <td>
                                                <form method="post" action="home.php" class="d-flex gap-2 align-items-center">
                                                    <input type="hidden" name="tp_id" value="<?php echo $pkg['tp_id']; ?>">
                                                    <input type="date" name="strt_date" required class="form-control form-control-sm" style="font-size: 12px; height: 32px;">
                                                    <button type="submit" name="schedule_conduction" class="btn btn-sm btn-luxury text-nowrap py-1" style="font-size: 11px;">Renew Session</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card shadow-sm border p-4 bg-white" style="border-radius: 16px; border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Currently Conducted / Scheduled Departures</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Package Name</th>
                                            <th>Start Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $conds_res = mysqli_query($conn, "SELECT c.*, p.tp_name FROM tourconduction_details c JOIN tourpackage_details p ON c.tp_id=p.tp_id ORDER BY c.tc_id DESC");
                                            while($cond = mysqli_fetch_assoc($conds_res)):
                                        ?>
                                        <tr>
                                            <td>#TC-<?php echo $cond['tc_id']; ?></td>
                                            <td class="fw-bold"><?php echo $cond['tp_name']; ?></td>
                                            <td><?php echo $cond['strt_date']; ?></td>
                                            <td>
                                                <span class="badge-admin <?php echo $cond['tc_status'] == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo $cond['tc_status'] == 1 ? 'Active / Scheduled' : 'Completed'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form method="post" action="home.php" class="d-inline">
                                                    <input type="hidden" name="tc_id" value="<?php echo $cond['tc_id']; ?>">
                                                    <input type="hidden" name="current_status" value="<?php echo $cond['tc_status']; ?>">
                                                    <button type="submit" name="toggle_conduction_status" class="btn btn-sm <?php echo $cond['tc_status'] == 1 ? 'btn-secondary' : 'btn-success text-white'; ?>">
                                                        <?php echo $cond['tc_status'] == 1 ? 'Mark Completed' : 'Mark Active'; ?>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- REGISTER HOTEL PANEL -->
                    <div id="reg-hotel" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Register New Hotel</h4>
                            <form method="post" action="home.php">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Hotel Name</label>
                                        <input type="text" name="h_name" required placeholder="e.g. Radisson Blu Resort">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Locality</label>
                                        <input type="text" name="h_loc" required placeholder="e.g. Near Mall Road">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">City</label>
                                        <input type="text" name="h_city" required placeholder="e.g. Shimla-171001">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Associated State</label>
                                        <select name="st_id" required>
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
                                        <label class="form-label-admin">Rate per Night (Rs.)</label>
                                        <input type="text" name="h_rate" required placeholder="e.g. Rs.4500">
                                    </div>
                                    
                                    <div class="col-md-3 col-6">
                                        <label class="form-label-admin">AC Rooms Count</label>
                                        <input type="number" name="ac_rm" required value="10">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="form-label-admin">Non-AC Rooms Count</label>
                                        <input type="number" name="nac_rm" required value="10">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="form-label-admin">Available AC Rooms</label>
                                        <input type="number" name="avlac_rm" required value="10">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="form-label-admin">Available Non-AC Rooms</label>
                                        <input type="number" name="avlnac_rm" required value="10">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-admin">Hotel Description / Amenities</label>
                                        <textarea name="h_desc" required placeholder="Describe hotel views, distance from transit, amenities, pool, dining options..."></textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" name="register_hotel" class="btn btn-luxury px-5 mt-3">Register Hotel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CATALOG & UPGRADES PANEL -->
                    <div id="upgrades" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Active Packages Upgrades</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Cost</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $pkgs = mysqli_query($conn, "SELECT * FROM tourpackage_details");
                                            while($pkg = mysqli_fetch_assoc($pkgs)):
                                        ?>
                                        <tr>
                                            <td><?php echo $pkg['tp_id']; ?></td>
                                            <td class="fw-bold"><?php echo $pkg['tp_name']; ?></td>
                                            <td><span class="text-success fw-bold"><?php echo $pkg['tp_cost']; ?></span></td>
                                            <td><?php echo $pkg['tp_dur']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-luxury" type="button" data-bs-toggle="collapse" data-bs-target="#editPkg_<?php echo $pkg['tp_id']; ?>">Upgrade</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="editPkg_<?php echo $pkg['tp_id']; ?>">
                                            <td colspan="5" class="bg-light p-4">
                                                <form method="post" action="home.php">
                                                    <input type="hidden" name="tp_id" value="<?php echo $pkg['tp_id']; ?>">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label-admin">New Cost</label>
                                                            <input type="text" name="tp_cost" value="<?php echo $pkg['tp_cost']; ?>" required>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="form-label-admin">New Duration</label>
                                                            <input type="text" name="tp_dur" value="<?php echo $pkg['tp_dur']; ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label-admin">New Itinerary / Description Details</label>
                                                            <textarea name="tp_dtls" required><?php echo $pkg['tp_dtls']; ?></textarea>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" name="upgrade_package" class="btn btn-sm btn-luxury px-4">Save Upgrade</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Hotel Registrations Upgrades</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Hotel Name</th>
                                            <th>Rate / Night</th>
                                            <th>Available (AC/Non-AC)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $htls = mysqli_query($conn, "SELECT * FROM hotel_details");
                                            while($htl = mysqli_fetch_assoc($htls)):
                                        ?>
                                        <tr>
                                            <td><?php echo $htl['h_id']; ?></td>
                                            <td class="fw-bold"><?php echo $htl['h_name']; ?></td>
                                            <td><span class="text-success fw-bold"><?php echo $htl['h_rate']; ?></span></td>
                                            <td><?php echo $htl['avlac_rm'] . " / " . $htl['avlnac_rm']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-luxury" type="button" data-bs-toggle="collapse" data-bs-target="#editHtl_<?php echo $htl['h_id']; ?>">Upgrade</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="editHtl_<?php echo $htl['h_id']; ?>">
                                            <td colspan="5" class="bg-light p-4">
                                                <form method="post" action="home.php">
                                                    <input type="hidden" name="h_id" value="<?php echo $htl['h_id']; ?>">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label-admin">New Nightly Rate</label>
                                                            <input type="text" name="h_rate" value="<?php echo $htl['h_rate']; ?>" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label-admin">Available AC Rooms</label>
                                                            <input type="number" name="avlac_rm" value="<?php echo $htl['avlac_rm']; ?>" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label-admin">Available Non-AC Rooms</label>
                                                            <input type="number" name="avlnac_rm" value="<?php echo $htl['avlnac_rm']; ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label-admin">Description / Amenities</label>
                                                            <textarea name="h_desc" required><?php echo $htl['h_desc']; ?></textarea>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" name="upgrade_hotel" class="btn btn-sm btn-luxury px-4">Save Upgrade</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- USER DIRECTORY PANEL -->
                    <div id="users" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Registered User Credentials</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Full Name</th>
                                            <th>Role</th>
                                            <th>Email Address</th>
                                            <th>Mobile No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Employees -->
                                        <?php
                                            $emps_res = mysqli_query($conn, "SELECT * FROM employee_details");
                                            while($emp = mysqli_fetch_assoc($emps_res)):
                                        ?>
                                        <tr>
                                            <td>EMP-<?php echo $emp['emp_id']; ?></td>
                                            <td class="fw-bold text-dark"><?php echo $emp['emp_name']; ?></td>
                                            <td>
                                                <span class="badge-admin <?php echo $emp['emp_type'] === 'A' ? 'bg-danger' : 'bg-primary'; ?>">
                                                    <?php echo $emp['emp_type'] === 'A' ? 'Admin' : 'Employee'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $emp['emp_email']; ?></td>
                                            <td><?php echo $emp['emp_mob']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                        
                                        <!-- Customers -->
                                        <?php
                                            $custs_res = mysqli_query($conn, "SELECT * FROM customer_details");
                                            while($c = mysqli_fetch_assoc($custs_res)):
                                        ?>
                                        <tr>
                                            <td>CUST-<?php echo $c['c_id']; ?></td>
                                            <td class="fw-bold text-dark"><?php echo $c['c_name']; ?></td>
                                            <td><span class="badge-admin bg-success">Customer</span></td>
                                            <td><?php echo $c['c_email']; ?></td>
                                            <td><?php echo $c['c_mob']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ORDERS / VERIFICATION PANEL -->
                    <div id="payments" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-radius: 16px; border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Orders & Bookings Verification</h4>
                            
                            <!-- Tab navigation for Tour and Hotel Orders -->
                            <ul class="nav nav-tabs mb-4" id="ordersTab" role="tablist" style="border-bottom: 2px solid #f0f4f7;">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-bold text-uppercase py-3 px-4" id="tour-orders-tab" data-bs-toggle="tab" data-bs-target="#tour-orders" type="button" role="tab" style="font-size: 11px; letter-spacing: 0.5px; border: none; border-bottom: 2px solid transparent; color: var(--color-navy);">🎒 Tour Orders</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold text-uppercase py-3 px-4" id="hotel-orders-tab" data-bs-toggle="tab" data-bs-target="#hotel-orders" type="button" role="tab" style="font-size: 11px; letter-spacing: 0.5px; border: none; border-bottom: 2px solid transparent; color: var(--color-navy);">🏨 Hotel Orders</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="ordersTabContent">
                                <!-- TOUR ORDERS TAB -->
                                <div class="tab-pane fade show active" id="tour-orders" role="tabpanel" aria-labelledby="tour-orders-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-luxury align-middle" style="font-size: 13px;">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Tour Package</th>
                                                    <th>Start Date</th>
                                                    <th>Persons</th>
                                                    <th>Booking Date</th>
                                                    <th>Price / Paid</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $tour_orders = mysqli_query($conn, "
                                                        SELECT b.bk_id, b.bk_person, b.bk_date, b.start_date, b.end_date,
                                                               c.c_name, p.tp_name, p.tp_cost,
                                                               pmt.pmt_id, pmt.pmt_status, pmt.pmt_type, pmt.pmt_amt
                                                        FROM booking_details b
                                                        JOIN customer_details c ON b.c_id = c.c_id
                                                        LEFT JOIN tourpackage_details p ON b.tp_id = p.tp_id
                                                        LEFT JOIN payment_details pmt ON b.bk_id = pmt.hbk_id AND pmt.booking_type = 'tour'
                                                        ORDER BY b.bk_id DESC
                                                    ");
                                                    if (mysqli_num_rows($tour_orders) === 0):
                                                ?>
                                                    <tr><td colspan="9" class="text-center text-muted py-3">No Tour Orders recorded.</td></tr>
                                                <?php
                                                    else:
                                                        while($to = mysqli_fetch_assoc($tour_orders)):
                                                ?>
                                                <tr>
                                                    <td>#TOUR-BK-<?php echo $to['bk_id']; ?></td>
                                                    <td class="fw-bold"><?php echo htmlspecialchars($to['c_name']); ?></td>
                                                    <td class="text-primary fw-bold"><?php echo htmlspecialchars($to['tp_name']); ?></td>
                                                    <td><?php echo $to['start_date'] ? date('d/m/Y', strtotime($to['start_date'])) : 'Pending'; ?></td>
                                                    <td><?php echo $to['bk_person'] ?: 1; ?> Head(s)</td>
                                                    <td><?php echo $to['bk_date'] ? date('d/m/Y', strtotime($to['bk_date'])) : 'Pending'; ?></td>
                                                    <td>
                                                        <span class="text-success fw-bold"><?php echo $to['tp_cost']; ?></span>
                                                        <?php if ($to['pmt_amt']): ?>
                                                            <br><span class="text-muted" style="font-size: 10px;">Paid: Rs. <?php echo number_format($to['pmt_amt']); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!$to['pmt_status']): ?>
                                                            <span class="badge-admin bg-secondary">Unpaid / Checkouts Pending</span>
                                                        <?php else: ?>
                                                            <span class="badge-admin <?php echo $to['pmt_status'] === 'Confirm' ? 'bg-success' : ($to['pmt_status'] === 'Cancelled' ? 'bg-danger' : 'bg-warning'); ?>">
                                                                <?php echo $to['pmt_status'] === 'Confirm' ? 'Authenticated' : $to['pmt_status']; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($to['pmt_status']) && $to['pmt_status'] !== 'Confirm' && $to['pmt_status'] !== 'Cancelled'): ?>
                                                            <form method="post" action="home.php" class="d-inline">
                                                                <input type="hidden" name="pmt_id" value="<?php echo $to['pmt_id']; ?>">
                                                                <button type="submit" name="confirm_payment" class="btn btn-sm btn-success text-white py-1 px-2" style="font-size: 11px;">Verify & Authenticate</button>
                                                            </form>
                                                        <?php elseif (isset($to['pmt_status']) && $to['pmt_status'] === 'Confirm'): ?>
                                                            <span class="text-success fs-6 fw-bold">✓ Authenticated</span>
                                                        <?php else: ?>
                                                            <span class="text-muted" style="font-size:11px;">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                        endwhile;
                                                    endif;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- HOTEL ORDERS TAB -->
                                <div class="tab-pane fade" id="hotel-orders" role="tabpanel" aria-labelledby="hotel-orders-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-luxury align-middle" style="font-size: 13px;">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Hotel Target</th>
                                                    <th>Room Type</th>
                                                    <th>Check-in / Check-out</th>
                                                    <th>Qty (Rooms/Pax)</th>
                                                    <th>Rate / Paid</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $hotel_orders = mysqli_query($conn, "
                                                        SELECT hb.hbk_id, hb.rm_type, hb.rooms, hb.adults, hb.children, hb.str_date, hb.end_date, hb.bk_date,
                                                               c.c_name, h.h_name, h.h_rate,
                                                               pmt.pmt_id, pmt.pmt_status, pmt.pmt_type, pmt.pmt_amt
                                                        FROM hotelbooking_details hb
                                                        JOIN customer_details c ON hb.c_id = c.c_id
                                                        LEFT JOIN hotel_details h ON hb.h_id = h.h_id
                                                        LEFT JOIN payment_details pmt ON hb.hbk_id = pmt.hbk_id AND pmt.booking_type = 'hotel'
                                                        ORDER BY hb.hbk_id DESC
                                                    ");
                                                    if (mysqli_num_rows($hotel_orders) === 0):
                                                ?>
                                                    <tr><td colspan="9" class="text-center text-muted py-3">No Hotel Orders recorded.</td></tr>
                                                <?php
                                                    else:
                                                        while($ho = mysqli_fetch_assoc($hotel_orders)):
                                                ?>
                                                <tr>
                                                    <td>#HOTEL-BK-<?php echo $ho['hbk_id']; ?></td>
                                                    <td class="fw-bold"><?php echo htmlspecialchars($ho['c_name']); ?></td>
                                                    <td class="text-primary fw-bold"><?php echo htmlspecialchars($ho['h_name']); ?></td>
                                                    <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars(strtoupper($ho['rm_type'])); ?></span></td>
                                                    <td>
                                                        📅 In: <?php echo date('d/m/Y', strtotime($ho['str_date'])); ?><br>
                                                        📅 Out: <?php echo date('d/m/Y', strtotime($ho['end_date'])); ?>
                                                    </td>
                                                    <td>
                                                        🔑 <?php echo $ho['rooms']; ?> Room(s)<br>
                                                        👥 <?php echo $ho['adults']; ?> A / <?php echo $ho['children']; ?> C
                                                    </td>
                                                    <td>
                                                        <span class="text-success fw-bold"><?php echo $ho['h_rate']; ?></span>
                                                        <?php if ($ho['pmt_amt']): ?>
                                                            <br><span class="text-muted" style="font-size: 10px;">Paid: Rs. <?php echo number_format($ho['pmt_amt']); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!$ho['pmt_status']): ?>
                                                            <span class="badge-admin bg-secondary">Unpaid / Checkouts Pending</span>
                                                        <?php else: ?>
                                                            <span class="badge-admin <?php echo $ho['pmt_status'] === 'Confirm' ? 'bg-success' : ($ho['pmt_status'] === 'Cancelled' ? 'bg-danger' : 'bg-warning'); ?>">
                                                                <?php echo $ho['pmt_status'] === 'Confirm' ? 'Authenticated' : $ho['pmt_status']; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($ho['pmt_status']) && $ho['pmt_status'] !== 'Confirm' && $ho['pmt_status'] !== 'Cancelled'): ?>
                                                            <form method="post" action="home.php" class="d-inline">
                                                                <input type="hidden" name="pmt_id" value="<?php echo $ho['pmt_id']; ?>">
                                                                <button type="submit" name="confirm_payment" class="btn btn-sm btn-success text-white py-1 px-2" style="font-size: 11px;">Verify & Authenticate</button>
                                                            </form>
                                                        <?php elseif (isset($ho['pmt_status']) && $ho['pmt_status'] === 'Confirm'): ?>
                                                            <span class="text-success fs-6 fw-bold">✓ Authenticated</span>
                                                        <?php else: ?>
                                                            <span class="text-muted" style="font-size:11px;">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                        endwhile;
                                                    endif;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CANCELLATIONS PANEL -->
                    <div id="cancellations" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Processed Cancellations & Refunds</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Booking ID</th>
                                            <th>Refund Charge</th>
                                            <th>Refund Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $cans_res = mysqli_query($conn, "SELECT can.*, c.c_name FROM cancellation_details can LEFT JOIN customer_details c ON can.c_id=c.c_id");
                                            while($can = mysqli_fetch_assoc($cans_res)):
                                        ?>
                                        <tr>
                                            <td>#CAN-<?php echo $can['can_id']; ?></td>
                                            <td class="fw-bold"><?php echo $can['c_name'] ? $can['c_name'] : "Customer (#".$can['c_id'].")"; ?></td>
                                            <td>#BK-<?php echo $can['hbk_id']; ?></td>
                                            <td class="text-danger">Rs. <?php echo number_format($can['can_charge']); ?></td>
                                            <td class="text-success fw-bold">Rs. <?php echo number_format($can['ref_amt']); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- REPORTS PANEL -->
                    <div id="reports" class="tab-panel">
                        <div class="card shadow-sm border p-4 bg-white mb-4" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Monthly Financial Analytics</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Total Bookings</th>
                                            <th>Gross Confirmed Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $m_rep = mysqli_query($conn, "SELECT DATE_FORMAT(pmt_date, '%M %Y') as month_yr, COUNT(*) as bookings, SUM(pmt_amt) as revenue FROM payment_details WHERE pmt_status='Confirm' AND pmt_date IS NOT NULL AND pmt_date != '0000-00-00' GROUP BY month_yr ORDER BY MIN(pmt_date) DESC");
                                            if (mysqli_num_rows($m_rep) == 0) {
                                                echo "<tr><td colspan='3' class='text-center text-muted'>No reports data found.</td></tr>";
                                            } else {
                                                while($rep = mysqli_fetch_assoc($m_rep)):
                                        ?>
                                        <tr>
                                            <td class="fw-bold text-dark"><?php echo $rep['month_yr']; ?></td>
                                            <td><?php echo $rep['bookings']; ?> bookings</td>
                                            <td class="text-success fw-bold">Rs. <?php echo number_format($rep['revenue']); ?></td>
                                        </tr>
                                        <?php 
                                                endwhile;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important;">
                            <h4 class="fw-bold mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Tour Conductions & Packages Summary</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-luxury align-middle">
                                    <thead>
                                        <tr>
                                            <th>Conduction ID</th>
                                            <th>Package Name</th>
                                            <th>Start Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $conductions = mysqli_query($conn, "SELECT tc.*, tp.tp_name FROM tourconduction_details tc JOIN tourpackage_details tp ON tc.tp_id=tp.tp_id ORDER BY tc.tc_id DESC");
                                            while($cond = mysqli_fetch_assoc($conductions)):
                                        ?>
                                        <tr>
                                            <td>#TC-<?php echo $cond['tc_id']; ?></td>
                                            <td class="fw-bold text-dark"><?php echo $cond['tp_name']; ?></td>
                                            <td><?php echo $cond['strt_date']; ?></td>
                                            <td>
                                                <span class="badge-admin <?php echo $cond['tc_status'] == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?php echo $cond['tc_status'] == 1 ? 'Scheduled' : 'Completed'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- ======================================================================
             CUSTOMER DASHBOARD INTERFACE (Modern Premium Layout)
             ====================================================================== -->
        <!-- Modern Welcome Banner Card -->
        <div class="mx-4 my-3">
            <div class="p-5 rounded-4 shadow-sm text-white position-relative overflow-hidden d-flex align-items-center" style="background: linear-gradient(135deg, #0f172a, #1e293b); height: 180px; border-radius: 20px;">
                <div class="position-absolute opacity-10 end-0 bottom-0" style="font-size: 15rem; transform: rotate(-15deg); margin-right:-50px; margin-bottom:-50px; user-select:none;">✈️</div>
                <div>
                    <h2 class="fw-bold m-0" style="font-family: var(--font-serif) !important; color: var(--color-gold);">Welcome Back, <?php echo $_SESSION['c_name']; ?>!</h2>
                    <p class="text-light opacity-75 mt-1 mb-0 font-serif" style="font-style: italic;">Explore your registered bookings and discover new upcoming luxury destinations.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4 my-4">
            <div class="row g-4">
                <!-- Left Sidebar: Services & Information -->
                <div class="col-lg-3">
                    <div class="card shadow-sm border p-4 mb-4 bg-white" style="border-color: #e1e8ed !important; border-radius: 16px;">
                        <h5 class="fw-bold mb-3 text-navy" style="font-family: var(--font-sans) !important; font-size: 14px; letter-spacing: 0.5px;">MY ACCOUNT</h5>
                        <div class="text-center py-3 border-bottom mb-3" style="border-color: #f0f4f7 !important;">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center text-white fw-bold mb-3 shadow-sm" style="width: 60px; height: 60px; background-color: var(--color-navy); font-size: 1.5rem; font-family: var(--font-sans);">
                                <?php echo strtoupper(substr($_SESSION['c_name'], 0, 1)); ?>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;"><?php echo $_SESSION['c_name']; ?></h6>
                            <span class="text-uppercase tracking-wider" style="color: #5e6d7c; font-size: 8px; font-weight: 700; letter-spacing: 1.5px; display: block;">Customer</span>
                        </div>
                        <a href="logout.php" class="btn btn-outline-danger w-100 py-2 btn-sm text-uppercase tracking-wider font-bold" style="border-radius: 6px; font-weight: 700; font-size: 11px;">Log Out</a>
                    </div>

                    <div class="card shadow-sm border p-4 bg-white" style="border-color: #e1e8ed !important; border-radius: 16px;">
                        <h5 class="fw-bold mb-3 text-navy" style="font-family: var(--font-sans) !important; font-size: 14px; letter-spacing: 0.5px;">QUICK SERVICES</h5>
                        <div class="d-flex flex-column gap-2 mb-4">
                            <a href="state1.php" class="btn btn-outline-secondary hover-card text-start py-2.5 px-3 border-secondary border-opacity-25 d-flex align-items-center gap-2" style="color: var(--color-navy); text-decoration: none; border-radius: 6px; font-size: 12px; font-weight:600;">
                                🗺️ Explore Places
                            </a>
                            <a href="tourpackages.php" class="btn btn-outline-secondary hover-card text-start py-2.5 px-3 border-secondary border-opacity-25 d-flex align-items-center gap-2" style="color: var(--color-navy); text-decoration: none; border-radius: 6px; font-size: 12px; font-weight:600;">
                                🎒 Tour Packages
                            </a>
                            <a href="tourconductions_details.php" class="btn btn-outline-secondary hover-card text-start py-2.5 px-3 border-secondary border-opacity-25 d-flex align-items-center gap-2" style="color: var(--color-navy); text-decoration: none; border-radius: 6px; font-size: 12px; font-weight:600;">
                                🚌 Tour Conductions
                            </a>
                            <a href="states.php" class="btn btn-outline-secondary hover-card text-start py-2.5 px-3 border-secondary border-opacity-25 d-flex align-items-center gap-2" style="color: var(--color-navy); text-decoration: none; border-radius: 6px; font-size: 12px; font-weight:600;">
                                🏨 Hotel Booking
                            </a>
                        </div>

                        <h5 class="fw-bold mb-3 text-navy" style="font-family: var(--font-sans) !important; font-size: 14px; letter-spacing: 0.5px;">HELP & POLICIES</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="about_us.php" class="text-decoration-none text-muted" style="font-size: 12px; font-weight: 500;">ℹ️ About Us</a>
                            <a href="contact_us.php" class="text-decoration-none text-muted" style="font-size: 12px; font-weight: 500;">📞 Contact Support</a>
                            <a href="rules of cancellation.php" class="text-decoration-none text-muted" style="font-size: 12px; font-weight: 500;">📋 Cancellation Rules</a>
                        </div>
                    </div>
                </div>

                <!-- Right Canvas: Active Bookings & Upcoming Schedules -->
                <div class="col-lg-9">
                    <!-- Section: My Booked Packages & Orders -->
                    <div class="card shadow-sm border p-4 bg-white mb-4" style="border-radius: 16px; border-color: #e1e8ed !important;">
                        <h5 class="fw-bold mb-4 text-navy" style="font-family: var(--font-sans) !important; font-size: 15px; letter-spacing: 0.5px;">My Registered Packages & Bookings</h5>
                        
                        <!-- Mini Tour Bookings Table -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2" style="font-size: 12px; letter-spacing: 0.5px;">🎒 Tour Bookings</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" style="font-size: 12.5px;">
                                    <thead>
                                        <tr class="table-light">
                                            <th>Booking ID</th>
                                            <th>Package Name</th>
                                            <th>Schedule (Start Date)</th>
                                            <th>Persons</th>
                                            <th>Rate</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $c_id = $_SESSION['c_id'];
                                            $my_tours = mysqli_query($conn, "
                                                SELECT b.bk_id, b.bk_person, b.bk_date, b.start_date, b.end_date,
                                                       p.tp_name, p.tp_cost, pmt.pmt_status, pmt.pmt_id
                                                FROM booking_details b
                                                JOIN tourpackage_details p ON b.tp_id = p.tp_id
                                                LEFT JOIN payment_details pmt ON b.bk_id = pmt.hbk_id AND pmt.booking_type = 'tour'
                                                WHERE b.c_id = $c_id
                                                ORDER BY b.bk_id DESC
                                            ");
                                            if (mysqli_num_rows($my_tours) === 0):
                                        ?>
                                            <tr><td colspan="7" class="text-center text-muted py-2">No tour bookings found.</td></tr>
                                        <?php
                                            else:
                                                while($mt = mysqli_fetch_assoc($my_tours)):
                                        ?>
                                        <tr>
                                            <td class="fw-bold">#TC-<?php echo $mt['bk_id']; ?></td>
                                            <td class="fw-bold text-navy"><?php echo htmlspecialchars($mt['tp_name']); ?></td>
                                            <td>📅 <?php echo $mt['start_date'] ? date('d/m/Y', strtotime($mt['start_date'])) : 'Pending'; ?></td>
                                            <td><?php echo $mt['bk_person'] ?: 1; ?> Head(s)</td>
                                            <td class="text-success fw-bold"><?php echo $mt['tp_cost']; ?></td>
                                            <td>
                                                <?php if (!$mt['pmt_status']): ?>
                                                    <span class="badge bg-secondary" style="font-size: 10px;">Checkout Incomplete</span>
                                                <?php else: ?>
                                                    <span class="badge <?php echo $mt['pmt_status'] === 'Confirm' ? 'bg-success' : ($mt['pmt_status'] === 'Cancelled' ? 'bg-danger' : 'bg-warning'); ?>" style="font-size: 10px;">
                                                        <?php echo $mt['pmt_status'] === 'Confirm' ? 'Confirmed' : $mt['pmt_status']; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$mt['pmt_status']): ?>
                                                    <a href="payments1_details.php?hbk_id=<?php echo $mt['bk_id']; ?>&price=<?php echo urlencode($mt['tp_cost']); ?>" class="btn btn-sm btn-warning py-0 px-2" style="font-size: 10px; font-weight: 700;">Pay Now</a>
                                                <?php elseif ($mt['pmt_status'] !== 'Cancelled'): ?>
                                                    <a href="cancellation_details.php?hbk_id=<?php echo $mt['bk_id']; ?>&pmt_id=<?php echo $mt['pmt_id']; ?>&can_charge=1000&ref_amt=<?php echo doubleval(preg_replace('/[^\d.]/', '', $mt['tp_cost'])) - 1000; ?>" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 10px; font-weight: 700;">Cancel</a>
                                                <?php else: ?>
                                                    <span class="text-muted" style="font-size: 10px;">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                                endwhile;
                                            endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mini Hotel Bookings Table -->
                        <div>
                            <h6 class="fw-bold text-secondary mb-2" style="font-size: 12px; letter-spacing: 0.5px;">🏨 Hotel Bookings</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" style="font-size: 12.5px;">
                                    <thead>
                                        <tr class="table-light">
                                            <th>Booking ID</th>
                                            <th>Hotel Name</th>
                                            <th>Check-in / Check-out</th>
                                            <th>Details</th>
                                            <th>Rate</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $my_hotels = mysqli_query($conn, "
                                                SELECT hb.hbk_id, hb.rm_type, hb.rooms, hb.str_date, hb.end_date, hb.bk_date,
                                                       h.h_name, h.h_rate, pmt.pmt_status, pmt.pmt_id
                                                FROM hotelbooking_details hb
                                                JOIN hotel_details h ON hb.h_id = h.h_id
                                                LEFT JOIN payment_details pmt ON hb.hbk_id = pmt.hbk_id AND pmt.booking_type = 'hotel'
                                                WHERE hb.c_id = $c_id
                                                ORDER BY hb.hbk_id DESC
                                            ");
                                            if (mysqli_num_rows($my_hotels) === 0):
                                        ?>
                                            <tr><td colspan="7" class="text-center text-muted py-2">No hotel bookings found.</td></tr>
                                        <?php
                                            else:
                                                while($mh = mysqli_fetch_assoc($my_hotels)):
                                        ?>
                                        <tr>
                                            <td class="fw-bold">#HBK-<?php echo $mh['hbk_id']; ?></td>
                                            <td class="fw-bold text-navy"><?php echo htmlspecialchars($mh['h_name']); ?></td>
                                            <td>
                                                In: <?php echo date('d/m/Y', strtotime($mh['str_date'])); ?><br>
                                                Out: <?php echo date('d/m/Y', strtotime($mh['end_date'])); ?>
                                            </td>
                                            <td>Room: <?php echo htmlspecialchars(strtoupper($mh['rm_type'])); ?><br>Qty: <?php echo $mh['rooms']; ?></td>
                                            <td class="text-success fw-bold"><?php echo $mh['h_rate']; ?></td>
                                            <td>
                                                <?php if (!$mh['pmt_status']): ?>
                                                    <span class="badge bg-secondary" style="font-size: 10px;">Checkout Incomplete</span>
                                                <?php else: ?>
                                                    <span class="badge <?php echo $mh['pmt_status'] === 'Confirm' ? 'bg-success' : ($mh['pmt_status'] === 'Cancelled' ? 'bg-danger' : 'bg-warning'); ?>" style="font-size: 10px;">
                                                        <?php echo $mh['pmt_status'] === 'Confirm' ? 'Confirmed' : $mh['pmt_status']; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$mh['pmt_status']): ?>
                                                    <a href="payment2_details.php?hbk_id=<?php echo $mh['hbk_id']; ?>&price=<?php echo urlencode($mh['h_rate']); ?>" class="btn btn-sm btn-warning py-0 px-2" style="font-size: 10px; font-weight: 700;">Pay Now</a>
                                                <?php elseif ($mh['pmt_status'] !== 'Cancelled'): ?>
                                                    <a href="cancellation_details.php?hbk_id=<?php echo $mh['hbk_id']; ?>&pmt_id=<?php echo $mh['pmt_id']; ?>&can_charge=1000&ref_amt=<?php echo doubleval(preg_replace('/[^\d.]/', '', $mh['h_rate'])) - 1000; ?>" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 10px; font-weight: 700;">Cancel</a>
                                                <?php else: ?>
                                                    <span class="text-muted" style="font-size: 10px;">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                                endwhile;
                                            endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Upcoming Departures -->
                    <div class="card shadow-sm border p-4 bg-white" style="border-radius: 16px; border-color: #e1e8ed !important;">
                        <h5 class="fw-bold mb-3 text-navy" style="font-family: var(--font-sans) !important; font-size: 15px; letter-spacing: 0.5px;">Upcoming Luxury Tour Departures</h5>
                        <p class="text-muted mb-4" style="font-size: 12px; margin-top:-5px;">Book a slot on one of our upcoming departures below.</p>
                        <div class="row g-3">
                            <?php
                                $upcomings = mysqli_query($conn, "
                                    SELECT c.tc_id, c.strt_date, p.tp_name, p.tp_dur, p.tp_cost, p.tp_id
                                    FROM tourconduction_details c
                                    JOIN tourpackage_details p ON c.tp_id = p.tp_id
                                    WHERE c.tc_status = 1
                                    ORDER BY c.tc_id DESC LIMIT 4
                                ");
                                if (mysqli_num_rows($upcomings) === 0):
                            ?>
                                <div class="col-12"><p class="text-muted text-center py-2">No upcoming departures scheduled currently.</p></div>
                            <?php
                                else:
                                    while($up = mysqli_fetch_assoc($upcomings)):
                            ?>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 hover-card bg-light bg-opacity-30 d-flex flex-column h-100 justify-content-between" style="border-color:#e1e8ed !important;">
                                        <div>
                                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2" style="font-size: 10px; font-weight: 700;">📅 Start: <?php echo htmlspecialchars($up['strt_date']); ?></span>
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;"><?php echo htmlspecialchars($up['tp_name']); ?></h6>
                                            <div class="text-muted mb-3" style="font-size: 11px;">⏱ <?php echo htmlspecialchars($up['tp_dur']); ?></div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2" style="border-color:#e1e8ed !important;">
                                            <span class="text-success fw-bold" style="font-size:14px;"><?php echo htmlspecialchars($up['tp_cost']); ?></span>
                                            <a href="bookings_details.php?tc_id=<?php echo $up['tc_id']; ?>&pname=<?php echo urlencode($up['tp_name']); ?>&price=<?php echo urlencode($up['tp_cost']); ?>" class="btn btn-luxury btn-sm py-1 px-3" style="font-size: 11px;">Book Slot</a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    endwhile;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Scripts: jQuery, Bootstrap 5 Bundle, Flux Slider -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($logged && $user_type === 'A'): ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching logic
            const buttons = document.querySelectorAll('.admin-sidebar-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    
                    // Save active tab to localStorage so it persists reloads
                    localStorage.setItem('activeAdminTab', target);

                    // Toggle active classes
                    buttons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const panels = document.querySelectorAll('.tab-panel');
                    panels.forEach(p => p.classList.remove('active'));
                    document.getElementById(target).classList.add('active');
                });
            });

            // Load active tab from localStorage if exists
            const savedTab = localStorage.getItem('activeAdminTab');
            if (savedTab) {
                const targetBtn = document.querySelector(`.admin-sidebar-btn[data-target="${savedTab}"]`);
                if (targetBtn) {
                    targetBtn.click();
                }
            }
        });
        </script>
    <?php else: ?>
        <script src="../js/flux.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sliderEl = document.getElementById('dashboardSlider');
            if (!sliderEl) return;

            // Store image sources initially
            const images = [];
            $(sliderEl).find('img').each(function() {
                images.push($(this).attr('src'));
            });

            let myFlux = null;
            let autoplayTimer = null;
            let transitioning = false;

            // Initialize Flux Slider
            function initFlux() {
                const width = $(sliderEl).width() || window.innerWidth;
                const height = $(sliderEl).height() || (window.innerHeight * 0.7);

                // Dynamically set background-size of tiles so the image fragments form a single continuous image
                $('#flux-tile-size-style').remove();
                $("<style id='flux-tile-size-style'>")
                    .prop("type", "text/css")
                    .html(`.fluxslider .tile { background-size: ${width}px ${height}px !important; }`)
                    .appendTo("head");

                // Disable library's internal autoplay and use custom robust loop instead
                myFlux = new flux.slider('#dashboardSlider', {
                    autoplay: false,
                    width: width,
                    height: height,
                    pagination: false,
                    controls: false,
                    transitions: ['bars', 'blinds', 'blocks', 'concentric', 'warp', 'cube', 'tiles3d', 'turn', 'slide', 'swipe', 'dissolve']
                });

                startAutoplay();
            }

            // Custom autoplay loop with lock to prevent animation overlaps
            function startAutoplay() {
                stopAutoplay();
                autoplayTimer = setTimeout(function() {
                    if (!transitioning && myFlux) {
                        transitioning = true;
                        myFlux.next();
                    }
                }, 5000);
            }

            function stopAutoplay() {
                if (autoplayTimer) {
                    clearTimeout(autoplayTimer);
                    autoplayTimer = null;
                }
            }

            // Listen for the transition end event on parent container to clear transition lock
            $(sliderEl).parent().on('fluxTransitionEnd', function() {
                transitioning = false;
                startAutoplay();
            });

            // Initialize for the first time
            initFlux();

            // Document visibility listener to pause slideshow when tab is inactive
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
            });

            // Handle window resizing to recalculate tile dimensions
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if (myFlux) {
                        stopAutoplay();
                        myFlux.stop();
                        
                        const parent = $('#dashboardSlider').parent();
                        $('#dashboardSlider').remove();
                        
                        const newSlider = $('<div id="dashboardSlider" class="rounded overflow-hidden shadow-sm" style="height: 70dvh; background: #000;"></div>');
                        images.forEach((src, idx) => {
                            newSlider.append(`<img src="${src}" alt="Slide ${idx + 1}">`);
                        });
                        parent.append(newSlider);
                        
                        // Reset lock and reinitialize
                        transitioning = false;
                        initFlux();
                    }
                }, 250);
            });
        });
        </script>
    <?php endif; ?>
    <?php mysqli_close($conn); ?>
</body>
</html>
