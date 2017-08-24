<?php
require_once("chart/conf.php");
?>
<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

?>
<?php
include_once("../db_conn/conn.php")
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>View Tables</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>

	<style>  
	.searchUL{  
		background-color:#eee;  
		cursor:pointer;  
	}  
	.searchLI{  
		padding:12px;  
	} 
canvas{    z-index: 0 !important;}
.pg_notify{display:none !important;}
	</style>  
	<style>

	/* Include the padding and border in an element's total width and height */
	* {
		box-sizing: border-box;
	}

	/* Remove margins and padding from the list */
	ul {
		margin: 0;
		padding: 0;
		list-style: none; 
	}

	/* Style the list items */
	ul li {
		cursor: pointer;
		position: relative;

		background: #eee;
		font-size: 18px;
		transition: 0.2s;

		/* make the list items unselectable */
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	.unselectable {
		-moz-user-select: -moz-none;
		-khtml-user-select: none;
		-webkit-user-select: none;
		-o-user-select: none;
		user-select: none
	}
	/* Set all odd list items to a different color (zebra-stripes) */
	ul li:nth-child(odd) {
		background: #f9f9f9;
	}
	.tickBagde{
		position:absolute;
		margin:-5px 0 0 -5px;
		padding-left:5px;
		padding-right:5px
	}
	</style>
</head>
<body style="background-color: #E4E4E4;">
	<?php 
	$user="";
	if(isset($_SESSION['admin_passwd']))
	{
		include("admin_navigation.php");
		$user=$_SESSION['admin_passwd'];
	}
	else{
		include("cashier_nav.php");
		$user=$_SESSION['cashier'];

	}


	?>
	<!--  -->
	<div class="w3-main " style="margin-left:300px;margin-top:43px;" id="view_container">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
		<!-- Header -->
		<header class="w3-container " style="padding-top:5px">
			<h5><b><i class="fa fa-coffee"></i> View Tables</b></h5>
		</header>

		<div class="w3-row-padding w3-margin-bottom divSmall" id="view_div" style="height: 400px;overflow-y: scroll;">


			<form method = "post" >
				<lable> from </lable>  <input type = "date" name = "from"  id = "from">
				<lable> to </lable> <input type = "date" name = "to" id = "to">

				<select class="form-control w3-col 4 w3-margin-bottom" name="menuitem" style="width:100px;" id="menuitem">
					<option class="w3-red" selected><b>Select Table</b></option>
					<?php                 
					$sqlmenu="SELECT * FROM menu_items";
					$menuresult=mysqli_query($conn,$sqlmenu);

					while($menuresultrow = mysqli_fetch_array( $menuresult))
					{
						echo '<option value="'.$menuresultrow['item_name'].'">'.$menuresultrow['item_name'].'</option>';
					}   
					?>  
				</select>
				<button class = "button" type = "submit" id = "submit" name = "submit" >data </button>
			</form>

			<?php
			if(isset($_POST['submit'])){
				$from = $_POST['from'];
				$to  = $_POST['to'];
				$item =  $_POST['menuitem'];


				$sql =   "SELECT * from order_table where ordered_items like '%$item%' AND date_time between '$from' and '$to'";
				$result = mysqli_query($conn,$sql);
				$result1 = mysqli_num_rows($result);
               // echo $result1;
			
                 $count = "0";
                
				$items_array = array();
				while($row = mysqli_fetch_array($result))
				{
                 
                  $sql1 = "SELECT * FROM order_table WHERE  date_time = '$from'";

                  $result1 = mysqli_query($conn,$sql1);

                 while($row1 = mysqli_fetch_array($result1)){
               // echo $row1['date_time'];

                 	$ordered_items  = $row1['ordered_items'];
				      $order_array=json_decode($ordered_items,true);
                                                                     
					        foreach($order_array as $k)
					        {  

					        	
					                if($k['item_name'] == $item)
							        {
							    	   $count = $count + $k['quantity'];

							    	   							    	 
							        }	

							  
		   					}

                 }
                echo $count;
             //   die();

                 $items_array[] = $count;
                  $count = "0";
           
				    $dateincrement = strtotime("+1 day", strtotime($from));
                    $from = date("Y-m-d", $dateincrement);    
           if($from > $to){
             break;

           }
            
                         		
		   				/*$date_time_count = 	count($row['date_time']);		   				
		   				$date_count = $date_count + $date_time_count;

					 if($temp != $row['date_time'] || $date_count == $result1)
					 {
                     
					     $items_array[] = $count2;					     
                     }
                   
                    $temp  = $row['date_time'];
                    $count2 = $count;*/
	            }
                   
				                
         
					$pc = new C_PhpChartX(array($items_array),'basic_chart');

					$pc->draw();
				}

				?>
			</div>
		</div>
	</body>
	</html>
	