<html>
<head>
</head>
<body>
<?php

	$st_name=$_GET["st_name"];
	$st_details=$_GET["st_details"];

 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into state_details
 (st_name,st_details) values
 ('$st_name','$st_details')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";
  	
 ?>
