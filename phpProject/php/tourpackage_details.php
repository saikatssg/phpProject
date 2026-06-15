<html>
<head>
</head>
<body>
<?php

	$tp_name=$_GET["tp_name"];
	$tp_details=$_GET["tp_details"];
	$tp_cost=$_GET["tp_cost"];
	$tp_dur=$_GET["tp_dur"];

 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into tourpackage_details
 (tp_name,tp_details,tp_cost,tp_dur) values
 ('$tp_name','$tp_details','$tp_cost','$tp_dur')";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
  
 ?>
