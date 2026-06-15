<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Form</title>

</head>
<body bgcolor="#FFFF66">
<?php
	$adm_name=$_GET["adm_name"];
	$adm_mob=$_GET["adm_mob"];
	$adm_email=$_GET["adm_email"];

 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into administrator_details
 (adm_name,adm_mob,adm_email) values
('$adm_name','$adm_mob','$adm_email')";
	echo "$query<br>";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";
  
 ?>
