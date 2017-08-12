<?php
include('../db_conn/conn.php');
if($_POST['id'])
{
	$delTable_id=$_POST['id'];
	$sql="DELETE FROM hotel_tables WHERE table_id='$delTable_id'";
	mysqli_query($conn,$sql);
	echo '<div class="alert alert-danger w3-red w3-margin">
	<strong>Table Deleted Permanantly!</strong> 
	</div>
	<script>
		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 900);
	</script>';
	
}
?>