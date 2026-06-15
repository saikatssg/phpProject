<?php
$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$packages = [
    [
        'tp_name' => 'ANDAMAN WILDLIFE & BEACHES',
        'tp_dtls' => 'Port Blair to Port Blair: Neil Island (2N), Havelock (2N). Covering Radhanagar Beach, Elephant Beach, Laxmanpur Beach, Chidiyatapu sunset point, and Cellular Jail light & sound show.',
        'tp_cost' => 'Rs.14500',
        'tp_dur' => '6 Days 5 Nights',
        'st_id' => 1,
        'p_id' => 1
    ],
    [
        'tp_name' => 'VIZAG TEMPLE & COASTAL VIBES',
        'tp_dtls' => 'Vizag (3N), Araku (2N). Covering Simhachalam Temple, Kailasagiri, Ramakrishna Beach, Submarine Museum, Borra Caves, and Padmapuram Gardens with local guide and vehicle.',
        'tp_cost' => 'Rs.11200',
        'tp_dur' => '6 Days 5 Nights',
        'st_id' => 2,
        'p_id' => 2
    ],
    [
        'tp_name' => 'DELHI & ROYAL AGRA HERITAGE',
        'tp_dtls' => 'Delhi (2N), Agra (2N), Vrindavan (1N). Covering Red Fort, Qutub Minar, Lotus Temple, Taj Mahal sunrise view, Agra Fort, Fatehpur Sikri, and Mathura temples.',
        'tp_cost' => 'Rs.13800',
        'tp_dur' => '6 Days 5 Nights',
        'st_id' => 3,
        'p_id' => 3
    ],
    [
        'tp_name' => 'GUJARAT HERITAGE & DIU BEACHES',
        'tp_dtls' => 'Ahmedabad (1N), Somnath (1N), Diu (2N), Dwarka (2N). Covering Sabarmati Ashram, Gir Forest Safari, Somnath Temple, Diu Fort, Nagoa Beach, and Dwarkadhish Temple.',
        'tp_cost' => 'Rs.18900',
        'tp_dur' => '8 Days 7 Nights',
        'st_id' => 4,
        'p_id' => 4
    ],
    [
        'tp_name' => 'HIMACHAL WILD KASOL & MANALI',
        'tp_dtls' => 'Shimla (2N), Manali (3N), Kasol (2N). Covering Kufri, Solang Valley adventure sports, Rohtang Pass, Manikaran hot springs, Kasol cafes, and Tosh valley trekking.',
        'tp_cost' => 'Rs.15400',
        'tp_dur' => '8 Days 7 Nights',
        'st_id' => 5,
        'p_id' => 5
    ],
    [
        'tp_name' => 'KASHMIR HEAVENLY ESCAPE',
        'tp_dtls' => 'Srinagar (3N), Pahalgam (2N), Gulmarg (1N). Covering Dal Lake Houseboat stay, Shalimar & Nishat Mughal Gardens, Gondola cable car ride, Betaab Valley, and Aru Valley.',
        'tp_cost' => 'Rs.16200',
        'tp_dur' => '7 Days 6 Nights',
        'st_id' => 6,
        'p_id' => 6
    ]
];

$inserted = 0;
foreach ($packages as $pkg) {
    $name = mysqli_real_escape_string($conn, $pkg['tp_name']);
    // Check if exists
    $check = mysqli_query($conn, "SELECT tp_id FROM tourpackage_details WHERE tp_name = '$name'");
    if (mysqli_num_rows($check) == 0) {
        $dtls = mysqli_real_escape_string($conn, $pkg['tp_dtls']);
        $cost = mysqli_real_escape_string($conn, $pkg['tp_cost']);
        $dur = mysqli_real_escape_string($conn, $pkg['tp_dur']);
        $st_id = intval($pkg['st_id']);
        $p_id = intval($pkg['p_id']);
        
        $sql = "INSERT INTO tourpackage_details (tp_name, tp_dtls, tp_cost, tp_dur, st_id, p_id) VALUES ('$name', '$dtls', '$cost', '$dur', $st_id, $p_id)";
        if (mysqli_query($conn, $sql)) {
            $inserted++;
            echo "Inserted package: {$pkg['tp_name']}\n";
        } else {
            echo "Error inserting {$pkg['tp_name']}: " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "Package already exists: {$pkg['tp_name']}\n";
    }
}

echo "Finished seeding. Inserted $inserted new packages.\n";
mysqli_close($conn);
?>
