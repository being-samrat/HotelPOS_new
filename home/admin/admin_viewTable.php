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
			<?php 
			$fetch_tables="SELECT * FROM hotel_tables ORDER BY table_name";
			$fetch_tables_result=mysqli_query($conn,$fetch_tables);
			
			while($row = mysqli_fetch_array( $fetch_tables_result))
			{
				$table_name=$row['table_name'];
				$color="";
				$print_kot="disabled";
				$print_bill="disabled";
				$hide="";
				if (($row['occupied']==1)) {
									# code...
					$color="#ff9800";
					$print_bill="";

					if (($row['join_id']=='-1')) {
						$color="#79E40D";
					}
				}

				if (($row['join_id']==0)) {
									# code...
					$hide="w3-hide";
				}

				if (($row['kot_open']>0)) {
									# code...
					$print_kot="";
				}
				
				$ac_Stat="NonA/C";
				if($row['status'] == '1'){
					$ac_Stat="A/C";
				}
				include("bill/billPrinted.php");
				$table_id=$row['table_id'];
				$kot_status="SELECT * FROM kot_table WHERE table_id='$table_id' AND print_status='1'";
				$kot_status_result=mysqli_query($conn,$kot_status);

				$kot_id="";
				while($row = mysqli_fetch_array( $kot_status_result))
				{

					$kot_id=$row['kot_id'];

				}
	           
				echo '
				<div class="w3-col l3 s6 w3-margin-bottom '.$hide.'">
		          <span class="w3-badge tickBagde w3-small w3-green '.$show_checked.'">&#10004;</span>
					<span class="w3-small w3-left w3-margin-left w3-text-white w3-padding-tiny">
						<span>'.$ac_Stat.'</span>
					</span>
					<span class="w3-small w3-right w3-text-white w3-padding-tiny">
						<a class="btn fa fa-remove" title="Clear order" onclick="clear_status('.$table_id.','.$table_name.')" style="padding:0px;"></a>
					</span>
					<div class="w3-container w3-red w3-padding-16 w3-card-4 w3-round-large">
						<div class="w3-left w3-circle w3-padding-small" id="'.$table_id.'" style="border:4px solid '.$color.';"><span class="w3-large">#'.$table_name.'</span></div>
						<div class="w3-right">
							<span class="w3-small fa fa-first-order"> &nbsp;<a class="btn w3-wide" href="table_order.php?table_id='.$table_id.'&table_no='.$table_name.'" style="padding:0px;">Order</a></span><br>

							<span class="w3-small fa fa-sticky-note"> &nbsp;<a class="btn w3-wide" target="_blank" href="bill_of_kot.php?kot_id='.$kot_id.'&table_no='.$table_name.'&table_id='.$table_id.'" style="padding:0px;" '.$print_kot.'>Print KOT</a></span><br>

							<span class="w3-small fa fa-print">&nbsp;<a class="btn w3-wide" target="_blank" href="bill_of_table.php?table_id='.$table_id.'&table_no='.$table_name.'" style="padding:0px;" '.$print_bill.'>Print Bill</a></span>          
						</div>

					</div>
				</div>';

			}   
			

			?>
			
		</div>
		<div class="w3-display-bottomright" style="position: fixed">
			<a class="w3-border-top btn w3-red w3-large w3-round-xlarge w3-card-16" href="join_table.php" style="margin:8px">Join Tables</a>
		</div>
		

		<!-- Modal for parcel order-->
		

	</div>
	<!--  -->
	
	
<script>

$(document).ready(function() {
  $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
  setInterval(function() {
  	$('#view_div').load('view_tab.php');
  }, 3000); // the "3000" 
});

</script>

<script>

	function clear_status(id,name){
		$.confirm({
			title: '<label class="w3-label w3-large">Clear Table Order!</label>',
			content: 'Ensure that the bill is printed before clearing the respective Table Order!!!',
			buttons: {
				confirm: function () {
					var dataS = 'id='+ id +'&no='+ name;
					$.ajax({
          url:"../waiter/clearStatus.php", //the page containing php script
          type: "POST", //request type
          data: dataS,
          cache: false,
          success:function(html){
          	$.alert(html);          
          }
      });

				},
				cancel: function () {

				}
			}
		});

	}

</script>
</body>
</html>