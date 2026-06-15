<?php
$link = mysqli_connect("localhost", "root", "", "travel_hotel_book");
if (mysqli_connect_errno()) {
    echo "Connect failed: " . mysqli_connect_error() . "\n";
    exit();
}

// 1. Check/Add columns in hotelbooking_details
$result = mysqli_query($link, "SHOW COLUMNS FROM `hotelbooking_details` LIKE 'rooms'");
$exists = mysqli_num_rows($result) > 0;

if (!$exists) {
    $query = "ALTER TABLE `hotelbooking_details` 
              ADD COLUMN `rooms` INT DEFAULT 1, 
              ADD COLUMN `adults` INT DEFAULT 1, 
              ADD COLUMN `children` INT DEFAULT 0;";
              
    if (mysqli_query($link, $query)) {
        echo "Database migration successful! Columns added to hotelbooking_details.\n";
    } else {
        echo "Error altering hotelbooking_details: " . mysqli_error($link) . "\n";
    }
} else {
    echo "hotelbooking_details columns already exist.\n";
}

// 2. Check/Add booking_type in payment_details
$result_pmt = mysqli_query($link, "SHOW COLUMNS FROM `payment_details` LIKE 'booking_type'");
$exists_pmt = mysqli_num_rows($result_pmt) > 0;

if (!$exists_pmt) {
    $query_pmt = "ALTER TABLE `payment_details` ADD COLUMN `booking_type` VARCHAR(10) DEFAULT 'tour';";
    if (mysqli_query($link, $query_pmt)) {
        echo "Database migration successful! booking_type added to payment_details.\n";
    } else {
        echo "Error altering payment_details: " . mysqli_error($link) . "\n";
    }
} else {
    echo "payment_details.booking_type already exists.\n";
}

mysqli_close($link);
?>
