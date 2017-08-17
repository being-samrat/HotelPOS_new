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
	<!-- !PAGE CONTENT! -->

	<div class="w3-row-padding w3-margin-bottom">
		<div class="w3-quarter w3-margin-bottom">
			<div class="w3-white" style="height: 400px">
				<div style="height: 200px;background-image: url('images/onepage_restaurant.jpg');padding-top: 150px"">
					<div class="w3-white w3-opacity" style="height: 50px;"></div>
				</div>
				<div class="w3-container col-lg-12 w3-xlarge" style="font-weight: bolder;">
					<span>Menu Item Name</span>
				</div>				
				<div class="col-lg-12" style="padding: 0">
					<div class="col-lg-12" style="max-height: 40px;overflow-y: hidden;">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
					<span class="w3-text-red w3-right w3-margin-right">...more</span>
				</div>
				
				<div class="col-lg-12 w3-margin-top" style="padding: 0">
				<div class="col-lg-6">
					<b><span>Qty: </span></b>	
					<input type="number" placeholder="Quantity" name="food_quantity" style="width: 80px">
				</div>          
				<div class="col-lg-6">
					<span class="w3-right w3-large"><b>Rate: 200.00</b></span>					
				</div>	
				</div>
				
				<div class="col-lg-12 w3-center w3-margin-top">
					<a class="w3-red btn btn-default" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
				</div>
			</div>
		</div>
		<div class="w3-quarter w3-margin-bottom">
			<div class="w3-white" style="height: 400px">
				<div style="height: 200px;background-image: url('images/onepage_restaurant.jpg');padding-top: 150px"">
					<div class="w3-white w3-opacity" style="height: 50px;"></div>
				</div>
				<div class="w3-container col-lg-12 w3-xlarge" style="font-weight: bolder;">
					<span>Menu Item Name</span>
				</div>				
				<div class="col-lg-12" style="padding: 0">
					<div class="col-lg-12" style="max-height: 40px;overflow-y: hidden;">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
					<span class="w3-text-red w3-right w3-margin-right">...more</span>
				</div>
				
				<div class="col-lg-12 w3-margin-top" style="padding: 0">
				<div class="col-lg-6">
					<b><span>Qty: </span></b>	
					<input type="number" placeholder="Quantity" name="food_quantity" style="width: 80px">
				</div>          
				<div class="col-lg-6">
					<span class="w3-right w3-large"><b>Rate: 200.00</b></span>					
				</div>	
				</div>
				
				<div class="col-lg-12 w3-center w3-margin-top">
					<a class="w3-red btn btn-default" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
				</div>
			</div>
		</div>
		<div class="w3-quarter w3-margin-bottom">
			<div class="w3-white" style="height: 400px">
				<div style="height: 200px;background-image: url('images/onepage_restaurant.jpg');padding-top: 150px"">
					<div class="w3-white w3-opacity" style="height: 50px;"></div>
				</div>
				<div class="w3-container col-lg-12 w3-xlarge" style="font-weight: bolder;">
					<span>Menu Item Name</span>
				</div>				
				<div class="col-lg-12" style="padding: 0">
					<div class="col-lg-12" style="max-height: 40px;overflow-y: hidden;">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
					<span class="w3-text-red w3-right w3-margin-right">...more</span>
				</div>
				
				<div class="col-lg-12 w3-margin-top" style="padding: 0">
				<div class="col-lg-6">
					<b><span>Qty: </span></b>	
					<input type="number" placeholder="Quantity" name="food_quantity" style="width: 80px">
				</div>          
				<div class="col-lg-6">
					<span class="w3-right w3-large"><b>Rate: 200.00</b></span>					
				</div>	
				</div>
				
				<div class="col-lg-12 w3-center w3-margin-top">
					<a class="w3-red btn btn-default" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
				</div>
			</div>
		</div>
		<div class="w3-quarter w3-margin-bottom">
			<div class="w3-white" style="height: 400px">
				<div style="height: 200px;background-image: url('images/onepage_restaurant.jpg');padding-top: 150px"">
					<div class="w3-white w3-opacity" style="height: 50px;"></div>
				</div>
				<div class="w3-container col-lg-12 w3-xlarge" style="font-weight: bolder;">
					<span>Menu Item Name</span>
				</div>				
				<div class="col-lg-12" style="padding: 0">
					<div class="col-lg-12" style="max-height: 40px;overflow-y: hidden;">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
					<span class="w3-text-red w3-right w3-margin-right">...more</span>
				</div>
				
				<div class="col-lg-12 w3-margin-top" style="padding: 0">
				<div class="col-lg-6">
					<b><span>Qty: </span></b>	
					<input type="number" placeholder="Quantity" name="food_quantity" style="width: 80px">
				</div>          
				<div class="col-lg-6">
					<span class="w3-right w3-large"><b>Rate: 200.00</b></span>					
				</div>	
				</div>
				
				<div class="col-lg-12 w3-center w3-margin-top">
					<a class="w3-red btn btn-default" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
				</div>
			</div>
		</div>
	</div>
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

<input type="file" accept="image/*;capture=camera"/>

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
