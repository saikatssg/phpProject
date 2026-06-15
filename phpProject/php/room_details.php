<html>
<head>
</head>
<body>
<?php

	$r_no=$_GET["r_no"];
	$r_ac=$_GET["r_ac"];
	$r_nac=$_GET["r_nac"];
	$r_charge=$_GET["r_charge"];
	
 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into room_details
 (r_no,r_ac,r_nac,r_charge) values
('$r_no','$r_ac','$r_nac','$r_charge')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";
  	
 ?>
