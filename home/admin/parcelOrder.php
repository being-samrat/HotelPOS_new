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

	<title>Parcel Orders</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
		<link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">

	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>

	<style type="text/css">
		
	</style>
</head>

<body style="background-color: #E4E4E4">
	<?php
	$user_name="";
	
	if(isset($_SESSION['admin_passwd']))
	{
		include("admin_navigation.php");
		$user_name=$_SESSION['admin_passwd'];
	}
	else{
		include("cashier_nav.php");
		$user_name=$_SESSION['cashier'];

	}


	?>
	<div class="w3-main " style="margin-left:300px;margin-top:43px;">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>

		<!-- Header -->
		<header class="w3-container " style="padding-top:22px">
			<h5><b><i class="fa fa-shopping-bag"></i> Parcel Ordering</b></h5>			
		</header>
		<div class="w3-center">
			<a class="btn w3-card-4 w3-round w3-text-red w3-center w3-margin-left w3-border" href="parcel/addParcel.php?parcelBy=<?php echo $user_name; ?>" title="ADD PARCEL"><span class="fa fa-plus-circle w3-large"></span> Add Parcel</a><br> 
		</div>
		
		<div class="col-lg-12 col-sm-12 w3-center">

			<div id="parcel_tabs">
				<?php 
				$fetch_parcels="SELECT * FROM parcel_table WHERE parcel_open=1 OR new_parcel=1 ORDER BY parcel_id DESC";
				$fetch_parcels_result=mysqli_query($conn,$fetch_parcels);
				$count=0;

				while($row = mysqli_fetch_array( $fetch_parcels_result))
				{
					$color="w3-red";
					$parcelBy=$row['parcelBy'];
					$parcel_id=$row['parcel_id'];

					if (($row['new_parcel']==1)) {
                  # code...
						$color="w3-green";
					}

					echo '
					<div class="w3-col l1 s4" style="margin:10px">
					<span class="w3-small w3-right w3-text-white">
						<a class="btn fa fa-remove" title="Delete & Clear Parcel" onclick="delParcel('.$row['parcel_id'].')" style="padding:0px;margin:1px 1px 0 1px;"></a>
					</span>
					<div class="w3-container '.$color.' w3-card-4 w3-round-large">
							<div class="" id="'.$parcel_id.'" >
								<a class="btn" href="parcelOrder.php?parcel_id='.$parcel_id.'&parcelBy='.$parcelBy.'" style="padding:0;margin-bottom:10px">
									<span class="w3-medium" title="Parcel No. '.$parcel_id.'">#P'.$parcel_id.'</span>
								</a>
							</div>						
						</div>
					</div>';

				}   

				?>
			</div>
		</div>

		<div class="">
			
			<div id="per_parcelOrder">

				<?php   
				if(isset($_GET['parcel_id'])) {
					include("parcel/per_parcelOrder.php"); }?>
				</div>
			</div>

		</div>
<script>

$(document).ready(function() {
  $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
  setInterval(function() {
  	$('#parcel_tabs').load('parcel/parcel_tabs.php');
  }, 3000); // the "3000" 
});

</script>

<script>
	function delParcel(id){
		$.confirm({
			title: '<label class="w3-xlarge w3-text-red w3-large fa fa-warning"> Clear Parcel Order!</label>',
			content: 'This will delete & clear the parcel order permanantly!!!',
			buttons: {
				confirm: function () {
					var dataS = 'id='+ id;
					$.ajax({
        url:"parcel/delParcel.php", //the page containing php script
        type: "POST", //request type
        data: dataS,
        cache: false,
        success:function(html){
        	
        	
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