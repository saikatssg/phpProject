<?php
	session_start();
?>
<?php

	if(!isset($_SESSION['c_id'])){
?>
<script type="text/javascript">
		alert("Please Log In First");
		window.location.href="../html/home.html";
</script>
<?php
	}
?>
<html>
<head>
<meta charset="utf-8">
<title>Tourism</title>
<link rel="stylesheet" type="text/css" href="../css/modern_ui.css">
<script type="text/javascript" src="../js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../js/flux.js"></script>
<script>

$(document).ready(function() {
	
	if(!flux.browser.supportsTransitions)
	alert("Flux Slider requires a browser that supports CSS3 transitions")
	
	window.f = new flux.slider('#slider',{
		pagination : true	
				});
	
    
});
</script>


</head>
<body background="../image/bg4.jpg">
<center>
<table  border="1">
  <tr height="15%;">
        <td background="../image/bg6.jpg" colspan="3"><h1><font color="#FFFF33"><center>PP travel ltd</center></font>
</h1></td>
</tr>
  <tr height="35%">
    <td colspan="3">
    
     <center>
   <div class="rain">
<div id="slider">
<img src="../image/sample.jpg" class="bgslide" >
<img src="../image/sample1.jpg" class="bgslide">
<img src="../image/sample2.jpg" class="bgslide">
<img src="../image/sample3.jpg" class="bgslide">
<img src="../image/sample4.jpg" class="bgslide">
<img src="../image/sample5.jpg" class="bgslide">

<div >

<!--<img src="../image/sample.jpg">
-->
</div>

</div>


  </div>
  </center>
    
   </td>
  </tr>
  <tr>
   <td width="10%">
   <h1><center>Menu</center></h1>
   <ul>
	<li><a href="places.php">Explorable Places</a></li>
	<li><a href="tourpackages.php">Package Tour Details</a></li>
	<li><a href="states.php">Hotel Details</a>
    </li>
   <li><a href="#">Tour Booking</a></li>
   <li><a href="../html/rules of cancellation.html">Rules Of Cancellation</a></li>
   </ul>
   </td>
    <td>
    <h1><u>Picture Slideshow</u></h1>
    <p>
    The NTFS file system provides better performance and security for data on hard disks and partitions or volumes than the FAT file system used in some earlier versions of Windows.<br><br>
Mounting a drive is a phrase commonly used to describe an advanced disk management technique that's often used in large organizations.
    </p>
       </td>
     <td width="25%">
    <fieldset><center>
    <a href="logout.php">
     <button>Log Out</button></a>
    </center>
    </fieldset>
     </td>
  </tr>
  <tr height="10%">
     <td colspan="3">
     <center><h1>
    <a href="">About Us</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="../html/contact us.html">Contact Us</a>
    </h1></center>
    </td>
  </tr>
</table>
</center>
</body>
</html>
