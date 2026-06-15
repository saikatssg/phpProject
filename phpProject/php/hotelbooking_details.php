<?php
session_start();

if (!isset($_SESSION['c_id'])) {
    header("Location: login_page.php");
    exit();
}

$c_id = $_SESSION['c_id'];
$h_id = isset($_GET["h_id"]) ? intval($_GET["h_id"]) : 0;
$rm_type = isset($_GET["rm_type"]) ? $_GET["rm_type"] : "AC";
$rooms = isset($_GET["rooms"]) ? intval($_GET["rooms"]) : 1;
$adults = isset($_GET["bk_person"]) ? intval($_GET["bk_person"]) : 1;
$children = isset($_GET["children"]) ? intval($_GET["children"]) : 0;
$price = isset($_GET["price"]) ? $_GET["price"] : "";

// Construct check-in date (str_date)
$check_in_DD = isset($_GET["check_in_DD"]) ? intval($_GET["check_in_DD"]) : 1;
$check_in_MM = isset($_GET["check_in_MM"]) ? intval($_GET["check_in_MM"]) : 1;
$check_in_YY = isset($_GET["check_in_YY"]) ? intval($_GET["check_in_YY"]) : 2026;
$str_date = "$check_in_YY-" . sprintf("%02d", $check_in_MM) . "-" . sprintf("%02d", $check_in_DD);

// Construct check-out date (end_date)
$check_out_DD = isset($_GET["check_out_DD"]) ? intval($_GET["check_out_DD"]) : 2;
$check_out_MM = isset($_GET["check_out_MM"]) ? intval($_GET["check_out_MM"]) : 1;
$check_out_YY = isset($_GET["check_out_YY"]) ? intval($_GET["check_out_YY"]) : 2026;
$end_date = "$check_out_YY-" . sprintf("%02d", $check_out_MM) . "-" . sprintf("%02d", $check_out_DD);

// Construct booking date (bk_date)
$DD = isset($_GET["DD"]) ? intval($_GET["DD"]) : 1;
$MM = isset($_GET["MM"]) ? intval($_GET["MM"]) : 1;
$YY = isset($_GET["YY"]) ? intval($_GET["YY"]) : 2026;
$bk_date = "$YY-" . sprintf("%02d", $MM) . "-" . sprintf("%02d", $DD);

$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book") or die("Connection failed");

$query = "INSERT INTO hotelbooking_details 
          (c_id, h_id, rm_type, str_date, end_date, bk_date, rooms, adults, children) 
          VALUES 
          ('$c_id', '$h_id', '$rm_type', '$str_date', '$end_date', '$bk_date', '$rooms', '$adults', '$children')";

$res = mysqli_query($conn, $query);
if ($res) {
    $hbk_id = mysqli_insert_id($conn);
    header("Location: payment2_details.php?hbk_id=" . urlencode($hbk_id) . "&price=" . urlencode($price));
    exit();
} else {
    echo "Error inserting booking: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
