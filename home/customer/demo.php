<?php

	session_start();
	if(!isset($_SESSION['custom']))
	{
		header("Location: index.php");
	}

include_once("../db_conn/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>HOTEL POS</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
	<style type="text/css">
		.table_view{
			background-image: url(admin/adminImg/empty.png);
			background-size: 40px;
			background-repeat: no-repeat;
			background-position: left;
			background-origin: content-box;
			padding-top:15px;
		}
	</style>

</head>
<body style="background-color: #E4E4E4">
    <span class="w3-margin w3-padding-small w3-grey"><a href="customer_logout.php">Logout</a></span>

	<!-- Top container -->
	 <div class="w3-main " style="margin-top:55px;">
    <div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
 <?php  
        $fetch_tables="SELECT * FROM menu_items";
        $fetch_tables_result=mysqli_query($conn,$fetch_tables);
        
        while($row = mysqli_fetch_array( $fetch_tables_result))
        {
          
          echo '
          <div class="w3-col l4 w3-col s6 w3-margin ">
            <div class="w3-container w3-padding-xlarge w3-card-8 w3-round-large" id="vacant_table_order" style="background-color:#79E40D">
              <div class="w3-left w3-circle w3-padding-small" id="'.$row['item_id'].'" style="border:4px solid white;"><span class="w3-large w3-text-white">#'.$row['item_name'].'</span>
              '.$_SESSION['custom'].'
              </div>
               <div class="w3-right">
               		
               		<a class="w3-red btn btn-default" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
               		
              </div>
            </div>
          </div>';
        }   

        ?>


<?php 
	
	if(isset($_SESSION['cart']))
	{
		$count=count($_SESSION['cart']);
		if($count>0)
		{
			echo "<br>";
			echo "<b>Cart items are:</b>";
			echo "<br>";
		}
		echo '<label>Cart Items: '.$count.'</label>';
		echo '<select name="cart">';
		for($i=0;$i<$count;$i++)
		{
			echo '<option>'.$_SESSION['cart'][$i].'</option>';
  			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
				echo '</select>';

	}

	
?>
</body>
</html>
