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
	
<body style="background-color: #E4E4E4">

		
		<div class="w3-col l12 w3-col s12 w3-white w3-padding">		
		<!-- Header -->
		<header class="w3-container " >
			<h5><b><i class="fa fa-coffee"></i> Join Tables</b></h5>
		</header>	
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
							<input style="width:16px;height:16px;" type="checkbox" name="join_tab[]" id="'.$row['table_id'].'" value="'.$row['table_id'].'"><label class="w3-right" for="'.$row['table_id'].'">&nbsp;Table no '.$row['table_name'].'</label>
						</div>';
						
					}   
					?>
				</div>
				
				<button class="btn btn-default w3-red w3-center" id="joinbtn" type="button" >Join Selected</button>
			</form>
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