<html>
<head>
</head>
<body>
<?php



 $conn=mysqli_connect("localhost","root","","travel_hotel_book")
 	or die("Connection failed");
 $query="insert into tourconduction_details
 (tc_name,tc_cost,tc_cost,ts_id,) values
 (Sudev Ghosh)";
  $res=mysqli_query($conn,$query);
  if($res)
  echo "One row inserted";	
 ?>
