<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tourist Spots</title>
<style type="text/css">
	#container{
		width:80%;
		margin:15px auto;
		padding:0px;
		
	}
    
	img{
		width:140px;
		height:150px;
	}
	td.lf{
		width:150px;
		margin-left:0px;
		padding-left:0px;
		background-color:#999900;
		text-align:center;
	}
	td.mid
	{
		width:270px;
		margin-left:0px;
		padding:0px 5px;
		background:linear-gradient(#CCC,transparent);
		text-align:center;
		font-size:12px;
		font-family:Arial, Helvetica, sans-serif;
		}
	td.rt{
		width:50px;
		background:linear-gradient(#339000,transparent);	
		padding:20px;
		font-size:14px;
		color:#000000;
	}
	.rtt
	{
		width:260px;
		height:90px;
		margin:0px;
		padding:0px 5px;
		padding-bottom:10px;
		text-align:justify;
		word-break:break-all;
		word-wrap:break-word;
		text-wrap:unrestricted;
		-ms-word-break:break-all;
		-ms-word-wrap:break-word;
		-ms-text-wrap:unrestricted;
		-webkit-word-break:break-all;
		-webkit-word-wrap:break-word;
		-webkit-text-wrap:unrestricted;
		}

	#logout{
		position:absolute;	
		z-index:900;
		top:125px;
		left:910px;
		width:90px;
		height:30px;
		backface-visibility:visible;
	}
    
          
       h1{
           
            margin: 0 auto;
            position: relative;
           top: 60px;
           height: 100px;
           line-height: 100px;
           background: url(../image/cover.jpg) ;
            background-size: cover;
            background-position: center;
            color: #efefef;
            font-size:50px;
            padding: 10px 0;
            font-family: sans-serif;
            font-weight: normal;
            text-align: center;
           margin-bottom: 2%;
        }
	.data{
		width:600px;
		break-after:right;
		text-wrap:unrestricted;
		}
	
		 table{
        margin-top: 5%;
        width: 100%;
        text-align: justify;
    }
</style>
</head>
<body>
	<div id="container" >
 
 <?php
$link = mysqli_connect("localhost", "root", "", "travel_hotel_book");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$p_id=$_GET["val"];
	$query = "SELECT * FROM touristspot_details where p_id=$p_id";

if ($result = mysqli_query($link, $query)) {
   echo "<table width=900px align=center >";

    /* fetch associative array */
    while ($row = mysqli_fetch_row($result)) {
	echo "<tr><td class=\"lf\"> ";
	echo "<img src=\"../image/t_spot/$row[0].jpg\" ><br>";
	echo "$row[1]<br/>$row[2]</td></tr>\n";
    }
    echo "</table>";

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($link);
?>  
    

 	</div>
</body>
</html>
