<?php
session_start();

if (!isset($_SESSION['c_id'])) {
    header("Location: login_page.php");
    exit();
}

$c_id = $_SESSION['c_id'];
$tc_id = isset($_GET["tc_id"]) ? intval($_GET["tc_id"]) : 0;
$bk_person = isset($_GET["bk_person"]) ? intval($_GET["bk_person"]) : 1;
$price = isset($_GET["price"]) ? $_GET["price"] : "";

$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book") or die("Connection failed");

// Resolve tc_id details: start date and duration to calculate journey details
$tp_id = 0;
$start_date = 'NULL';
$end_date = 'NULL';

if ($tc_id > 0) {
    $tc_query = "SELECT c.strt_date, c.tp_id, p.tp_dur 
                 FROM tourconduction_details c 
                 JOIN tourpackage_details p ON c.tp_id = p.tp_id 
                 WHERE c.tc_id = $tc_id";
    $tc_res = mysqli_query($conn, $tc_query);
    if ($tc_res && $row = mysqli_fetch_assoc($tc_res)) {
        $tp_id = intval($row['tp_id']);
        $strt_str = $row['strt_date']; // format DD/MM/YYYY
        $tp_dur = $row['tp_dur'];
        
        // Parse start date robustly (handles DD/MM/YYYY, YYYY-MM-DD, etc.)
        $formatted_start = '';
        if (preg_match('/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})$/', $strt_str, $matches)) {
            $formatted_start = sprintf('%04d-%02d-%02d', $matches[1], $matches[2], $matches[3]);
        } elseif (preg_match('/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/', $strt_str, $matches)) {
            $formatted_start = sprintf('%04d-%02d-%02d', $matches[3], $matches[2], $matches[1]);
        } else {
            $ts = strtotime(str_replace('/', '-', $strt_str));
            if ($ts !== false) {
                $formatted_start = date('Y-m-d', $ts);
            }
        }
        
        if (!empty($formatted_start)) {
            $start_date = "'$formatted_start'";
            
            // Extract number of days from duration (e.g., "7 Days 6 Nights")
            preg_match('/(\d+)\s*Day/i', $tp_dur, $matches);
            $days = isset($matches[1]) ? intval($matches[1]) : 1;
            
            // Calculate end date (start date + duration days - 1)
            $end_timestamp = strtotime($formatted_start . " + " . ($days - 1) . " days");
            $formatted_end = date('Y-m-d', $end_timestamp);
            $end_date = "'$formatted_end'";
        }
    }
}

// Construct booking placement date (bk_date)
$DD = isset($_GET["DD"]) ? intval($_GET["DD"]) : intval(date('d'));
$MM = isset($_GET["MM"]) ? intval($_GET["MM"]) : intval(date('m'));
$YY = isset($_GET["YY"]) ? intval($_GET["YY"]) : intval(date('Y'));
$bk_date = "$YY-" . sprintf("%02d", $MM) . "-" . sprintf("%02d", $DD);

// Server-side date conflict check (Booking Date must be <= Tour Start Date)
if ($start_date !== 'NULL') {
    $start_date_clean = trim($start_date, "'");
    if (strtotime($bk_date) > strtotime($start_date_clean)) {
        die("<div style='font-family:sans-serif; padding: 40px; text-align:center;'><h3 style='color:#ef4444;'>Validation Error</h3><p>Booking placement date ($bk_date) cannot be after the actual tour start date ($start_date_clean).</p><p><a href='javascript:history.back()'>Go Back</a></p></div>");
    }
}

$query = "INSERT INTO booking_details 
          (c_id, tc_id, tp_id, bk_person, bk_date, start_date, end_date) 
          VALUES 
          ('$c_id', '$tc_id', '$tp_id', '$bk_person', '$bk_date', $start_date, $end_date)";

$res = mysqli_query($conn, $query);
if ($res) {
    $bk_id = mysqli_insert_id($conn);
    header("Location: payments1_details.php?hbk_id=" . urlencode($bk_id) . "&price=" . urlencode($price));
    exit();
} else {
    echo "Error inserting tour booking: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
