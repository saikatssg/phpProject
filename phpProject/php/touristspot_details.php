<html>
<head>
</head>
<body>
<?php

	$ts_name=$_GET["p_name"];
	$ts_details=$_GET["p_details"];

 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into touristspot_details
 (ts_name,ts_details) values
 (''$ts_name','$ts_details')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
 ?>
