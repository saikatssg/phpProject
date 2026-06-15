<?php
	session_start();
	
?>

<html>
<head>
</head>
<body>
<?php

$user=$_POST["user"];
$pass=$_POST["pass"];
$user_type=$_POST["user_type"];
$flag=0;

 $link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$query="select ";

if($user_type=="C"){
	$query .="c_id, c_name from customer_details where c_email='$user' and c_pswd='$pass'";
}
else if($user_type=="A"){
	$query .="emp_id, emp_name from employee_details where emp_email='$user' and emp_pswd='$pass' and emp_type='A'";
}
else if($user_type=="E"){
	$query .="emp_id, emp_name from employee_details where emp_email='$user' and emp_pswd='$pass' and emp_type='E'";
}
// echo "$query<br>";
  if ($result = mysqli_query($link, $query)) {
    /* fetch associative array */
    while ($row = mysqli_fetch_row($result)) {

  //echo "c_id is $row[0]";
  if(!isset($_SESSION['c_id'])){
	$_SESSION['c_id']=$row[0];
	$_SESSION['c_name']=$row[1];
	$_SESSION['user_type']=$user_type;
  }
	$flag=1;
	}
	/* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($link);
if($flag==1){
?>
<script type="text/javascript">
		/*alert("Login Successful");*/
		window.location.href="home.php";
</script>
<?php
} else {

?>
<script type="text/javascript">
alert("usertype,email or password does not match");
window.location.href="login_page.php";
</script>
<?php
}
?>
 </body>
 </html>
