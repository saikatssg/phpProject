<html>
<head>
</head>
<body>
<?php

	$p_name=$_GET["p_name"];
	$p_details=$_GET["p_details"];
	
	
 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into place_details
 (p_name,p_details) values
 ('$p_name','$p_details')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
 ?>
