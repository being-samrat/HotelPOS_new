<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php")
?>
<?php
session_start();

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

	<style type="text/css">
		.table_view{
			background-image: url(adminImg/empty.png);
			background-size: 40px;
			background-repeat: no-repeat;
			background-position: left;
			background-origin: content-box;
			padding-top:15px;
		}
	</style>
</head>

<body style="background-color: #E4E4E4">

	<?php 
	if(isset($_SESSION['admin_passwd']))
	{

		include("admin_navigation.php");
	}
	else{
		include("cashier_nav.php");
	}


	?>
	<!--  -->
	<div class="w3-main " style="margin-left:300px;margin-top:43px;">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
		<!-- Header -->
		<header class="w3-container " style="padding-top:22px">
			<h5><b><i class="fa fa-coffee"></i> Join Tables</b></h5>
		</header>
		<div class="w3-col l12 w3-col s12 w3-white w3-margin-left w3-padding">			
			<form method="POST">
				<div class="well" style="height: 300px;overflow-y: scroll;padding-left: 0px">
					<?php 
					$fetch_tables="SELECT * FROM hotel_tables WHERE join_id='-1' ORDER BY table_name";
					$fetch_tables_result=mysqli_query($conn,$fetch_tables);
					
					while($row = mysqli_fetch_array( $fetch_tables_result))
					{
						$ac_Stat="Non A/c";
						if($row['status'] == '1'){
							$ac_Stat="A/c";
						}
						echo '
						<div class="w3-col l2 w3-red w3-margin-left w3-margin-bottom w3-card-8 w3-round w3-padding-tiny">
							<div class="w3-right w3-small" style="margin:2px">'.$ac_Stat.'</div>
							<input style="width:16px;height:16px;" type="checkbox" name="join_tab[]" id="'.$row['table_id'].'" value="'.$row['table_id'].'"><label for="'.$row['table_id'].'">&nbsp;Table no '.$row['table_name'].'</label>
						</div>';
						
					}   
					?>
				</div>
				
				<button class="btn btn-default w3-red w3-center" id="joinbtn" type="button" >Join Selected</button>
			</form>
		</div>	

	</div>

	<script>
		$(document).ready(function() {

			$('#joinbtn').click(function() {
				var data = $("form").serialize(); 

   //             	var tableID= "-1";
			// var tableNO= "-1";
			$.ajax({
				type: "POST",
				url: "Update_join.php",
				data: data,
				cache: false,
				success: function(response) {
					$.alert({
						title: 'Join Alert',
						content: response,
						buttons: {
							ok: function () {
								location.reload();
							}}
						});				
				},
				error: function(xhr, textStatus, errorThrown) {
					$.alert('request failed');
				}
			});
		});
		});

		
	</script>
</body>
</html>