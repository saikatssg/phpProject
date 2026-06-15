<?php
	session_start();
	$logged=0;
	if(isset($_SESSION['c_id']) && 
		$_SESSION['c_id']!= null){
		$logged=1;
	} else {
		header("Location: login_page.php");
		exit();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       .navbar-brand{
        width: 5%;
       }

       header{
        width: 100%;
        height: 97.6dvh;
       
        background: url(../image/road.jpg);
        background-attachment: fixed;
        background-size: cover;
        background-position: bottom;
       }

       header h1{
        font-weight: 400 !important;
        color: yellow;
        font-size: 78px;
        letter-spacing: 2px;
       }

       .flex{
        display: flex;
        align-items: center;
        justify-content: center;
       }
       .fwrap{
        margin-top: 50px;
        width: 80%;
        height: 60dvh;
        background-color: white;
       }

       .mug,.form{
        width: 100%;
        height: 60dvh;
        flex-direction: column !important;
        
       }

       .mug img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
       }
     
       
       .form form{
        width: 90%;
         
       }

       .form form .form-label,
       .form form .form-control
       {
        margin: 10px 0;
       }

       .form form .form-control{
        outline: none !important;
        box-shadow: none;
        border-color: #8576FF;
         
       }

        .form-label{
        color:#850F8D;
        font-size: 20px;
        
       }

       .form-check-input {
        border:1px solid violet !important;
        transition: all 0.3s;
       }

       .form-check-label{
        cursor: pointer !important;
       }
       .form-check-input:checked {
        border:1px solid violet !important;
        background: violet;
         box-shadow: inset 0px 0px 0px 2px white,0px 0px 0px 4px rgba(255, 118, 206,0.3) !important ;
       }


        
    
    </style>
</head>
<body>
    
 

    <?php include "nav.php";   ?>

<header>

       <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center my-5">PP travel ltd</h1>
            </div>
        </div>
       </div>
       <h2 class="display-3 text-center font-normal text-light my-4">Hello <?php echo $_SESSION['c_name']; ?>!</h2>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
