<?php
session_start();

// Read inputs supporting both POST and GET
$m_name = isset($_POST["m_name"]) ? $_POST["m_name"] : (isset($_GET["m_name"]) ? $_GET["m_name"] : "");
$addr = isset($_POST["addr"]) ? $_POST["addr"] : (isset($_GET["addr"]) ? $_GET["addr"] : "");
$m_mob = isset($_POST["m_mob"]) ? $_POST["m_mob"] : (isset($_GET["m_mob"]) ? $_GET["m_mob"] : "");
$gen = isset($_POST["gen"]) ? $_POST["gen"] : (isset($_GET["gen"]) ? $_GET["gen"] : "");
$email = isset($_POST["email"]) ? $_POST["email"] : (isset($_GET["email"]) ? $_GET["email"] : "");
$dd = isset($_POST["DD"]) ? $_POST["DD"] : (isset($_GET["DD"]) ? $_GET["DD"] : "");
$mm = isset($_POST["MM"]) ? $_POST["MM"] : (isset($_GET["MM"]) ? $_GET["MM"] : "");
$yy = isset($_POST["YY"]) ? $_POST["YY"] : (isset($_GET["YY"]) ? $_GET["YY"] : "");
$pswd = isset($_POST["pswd"]) ? $_POST["pswd"] : (isset($_GET["pswd"]) ? $_GET["pswd"] : "");

// Sanitize & Trim
$m_name = trim($m_name);
$addr = trim($addr);
$m_mob = trim($m_mob);
$email = trim($email);
$pswd = trim($pswd);

// Basic Validation
if (empty($m_name) || empty($addr) || empty($m_mob) || empty($email) || empty($pswd) || empty($dd) || empty($mm) || empty($yy)) {
    ?>
    <script type="text/javascript">
        alert("All fields are required. Please fill out the registration form completely.");
        window.history.back();
    </script>
    <?php
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if email or mobile already exists
$email_esc = mysqli_real_escape_string($conn, $email);
$mob_esc = mysqli_real_escape_string($conn, $m_mob);

$check_query = "SELECT * FROM customer_details WHERE c_email = '$email_esc' OR c_mob = '$mob_esc' LIMIT 1";
$check_res = mysqli_query($conn, $check_query);

if ($check_res && mysqli_num_rows($check_res) > 0) {
    // Account exists! Redirect to login page
    $row = mysqli_fetch_assoc($check_res);
    $match_reason = ($row['c_email'] === $email) ? "Email address" : "Mobile number";
    ?>
    <script type="text/javascript">
        alert("An account with this <?php echo $match_reason; ?> is already registered. Redirecting to the Login page.");
        window.location.href = "login_page.php";
    </script>
    <?php
    mysqli_close($conn);
    exit();
}

// Safe Insert
$name_esc = mysqli_real_escape_string($conn, $m_name);
$addr_esc = mysqli_real_escape_string($conn, $addr);
$gen_esc = mysqli_real_escape_string($conn, $gen);
$dob = mysqli_real_escape_string($conn, "$dd/$mm/$yy");
$pswd_esc = mysqli_real_escape_string($conn, $pswd);

$query = "INSERT INTO customer_details (c_name, c_addr, c_mob, c_gen, c_email, c_dob, c_pswd) VALUES 
          ('$name_esc', '$addr_esc', '$mob_esc', '$gen_esc', '$email_esc', '$dob', '$pswd_esc')";

$res = mysqli_query($conn, $query);
if ($res) {
    ?>
    <script type="text/javascript">
        alert("Registration Successful! Please sign in with your credentials.");
        window.location.href = "login_page.php";
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Registration failed: <?php echo mysqli_real_escape_string($conn, mysqli_error($conn)); ?>");
        window.history.back();
    </script>
    <?php
}

mysqli_close($conn);
?>
