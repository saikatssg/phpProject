<?php
$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conductions = [
    ['tp_id' => 1, 'strt_date' => '18/06/2026'],
    ['tp_id' => 1, 'strt_date' => '05/07/2026'],
    
    ['tp_id' => 2, 'strt_date' => '20/06/2026'],
    ['tp_id' => 2, 'strt_date' => '12/07/2026'],
    
    ['tp_id' => 3, 'strt_date' => '22/06/2026'],
    ['tp_id' => 3, 'strt_date' => '15/07/2026'],
    
    ['tp_id' => 4, 'strt_date' => '25/06/2026'],
    ['tp_id' => 5, 'strt_date' => '28/06/2026'],
    ['tp_id' => 6, 'strt_date' => '30/06/2026'],
    ['tp_id' => 7, 'strt_date' => '01/07/2026'],
    ['tp_id' => 8, 'strt_date' => '03/07/2026'],
    
    ['tp_id' => 19, 'strt_date' => '19/06/2026'],
    ['tp_id' => 19, 'strt_date' => '10/07/2026'],
    
    ['tp_id' => 20, 'strt_date' => '21/06/2026'],
    ['tp_id' => 20, 'strt_date' => '14/07/2026'],
    
    ['tp_id' => 21, 'strt_date' => '23/06/2026'],
    ['tp_id' => 21, 'strt_date' => '18/07/2026'],
    
    ['tp_id' => 22, 'strt_date' => '26/06/2026'],
    ['tp_id' => 23, 'strt_date' => '29/06/2026'],
    ['tp_id' => 24, 'strt_date' => '02/07/2026']
];

$inserted = 0;
foreach ($conductions as $cond) {
    $tp_id = intval($cond['tp_id']);
    $strt_date = mysqli_real_escape_string($conn, $cond['strt_date']);
    
    // Check if conduction for this package and date already exists
    $check = mysqli_query($conn, "SELECT tc_id FROM tourconduction_details WHERE tp_id = $tp_id AND strt_date = '$strt_date'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO tourconduction_details (tp_id, strt_date, tc_status) VALUES ($tp_id, '$strt_date', 1)";
        if (mysqli_query($conn, $sql)) {
            $inserted++;
            echo "Inserted conduction for package ID {$tp_id} on {$strt_date}\n";
        } else {
            echo "Error inserting conduction: " . mysqli_error($conn) . "\n";
        }
    }
}

echo "Finished seeding conductions. Inserted $inserted rows.\n";
mysqli_close($conn);
?>
