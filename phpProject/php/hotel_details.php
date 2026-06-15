<html>
<head>
</head>
<body>
<?php

	$h_name=$_GET["h_name"];
	$h_loc=$_GET["h_loc"];
	$h_city=$_GET["h_city"];
	$h_rate=$_GET["h_rate"];
	$h_desc=$_GET["h_desc"];
	
 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into hotel_details
 (h_name,h_city,h_state,h_pin) values
('$h_name','$h_loc','$h_city','$h_rate','$h_desc')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
 ?>
