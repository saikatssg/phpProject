<?php
	session_start();
?>
<?php
	$logged=0;
	if(isset($_SESSION['c_id']) && 
		$_SESSION['c_id']!= null){
		$logged=1;
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
<style type="text/css">
	.acc{
		font-size:24px;
		text-transform:capitalize;
		font-variant:small-caps;
	}
	.acc_top{
		font-size:36px;
		padding:5px;
		height:45%;
		text-transform:capitalize;
		font-variant:small-caps;
		border:4px solid #999;
	}
	.acc_bottom{
		
		font-size:36px;
		padding:10px 5px;
		text-transform:capitalize;
		font-variant:small-caps;
		border:4px solid #999;
	}
</style>
</head>
<body background="../image/bg4.jpg">
<center>
<table  border="1">
  <tr height="10%;">
        <td background="../image/banner_1.jpg" colspan="3"><div style="font-size:50px"><font color="#333333"><b><i>PP travel ltd</i></b></font></div>
</td>
</tr>
  <tr height="30%">
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
<td width="20%">
     <fieldset>
     <a href="about_us.php"><div style="font-size:34px"><b>About Us</b></div></a><br/> </fieldset><br/><br/>
<fieldset><a href="contact_us.php"><div style="font-size:34px"><b>Contact Us</b></div></a><br/></fieldset>
 </td>
   <td><ul>
<div class="contentbox">
<center><div class="acc_top"><a href="state1.php">Explorable Places</a></div>
<div class="acc_top"><a href="tourpackages.php">Tour Package Details</a></div>
<div class="acc_top"><a href="tourconductions_details.php">Tour Conduction</a></div>
<div class="acc_bottom"><a href="states.php">Hotel Booking</a></div></center>
</div>
   </ul>
	</td>
          <td width="16%">
 <?php
	if($logged==0){
 ?>
     <form method="post" action="login_form.php">
     <fieldset>
     <legend><b>Login</b></legend>
    <input type="radio" name="user_type" value="A"><b><i>Administrator</i></b><br>
    <input type="radio" name="user_type" value="C"><b><i>Customer</i></b><br>
	<input type="radio" name="user_type" value="E"><b><i>Employee</i></b><br>
     Email-id : <input type="text" id="user" name="user" placeholder="Email-id"><br> 
     Password : <input type="password" id="pass" name="pass" placeholder="Password">
     <center>
<br>  <input type="submit" value="SUBMIT">
     </center>
     </form><br/>
     </fieldset>
<?php
	} else {
		echo "<b><i>Hello,</b></i><br><label><center><b><h3>".$_SESSION['c_name'] ."</h3></b></center></label><br>";
?>
    <fieldset><center>
    <a href="logout.php">
    <button>Log Out</button></a>
    </center>
    </fieldset>
<?php
	}
?>
<form method="post" action="cust_details.php">
  <fieldset>   
<center>
  <div style="font-size:14px"><b><i>New User? Create Account</i></b></div>
    <button><a href="cust_details.php">Sign-Up</a></button>
</center>
</fieldset>
  </td>
  </tr>
  <tr height="7%">
     <td colspan="3">
  <footer>
 <center><div style="font-size:40px"><b>
<a href="rules of cancellation.php">Rules Of Cancellation</a></b></div></center>
</footer>
</td></tr>
 </table>
 </center>
 </body>
 </html>
