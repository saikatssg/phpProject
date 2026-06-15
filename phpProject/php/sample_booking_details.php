<?php
	session_start();
?>
<html>
<head>
</head>
<body bgcolor="#33FFCC">
<?php

	if(!isset($_SESSION['c_id'])){
?>
<script type="text/javascript">
		alert("Please Log In First");
		window.location.href="../html/home.html";
</script>
<?php
	} else {

	$c_id=$_GET["c_id"];
	$bk_person=$_GET["bk_person"];
	$bk_date=$_GET["bk_date"];
	
 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into booking_details
 (c_id,bk_person,bk_date) values
 ('$c_id','$bk_person','bk_date')";
 	echo "$query<br>";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
  
	}
 ?>
