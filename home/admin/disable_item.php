<?php
include('../db_conn/conn.php');
//echo "hello";
if($_GET['item_id'])
{
	$id=$_GET['item_id'];
	$sql="UPDATE menu_items SET visible='0' WHERE item_id='$id'";
	
	if((mysqli_query($conn,$sql))==TRUE){
		echo "<script>alert('Menu Item Deleted');
		window.location.href='admin_manageSettings.php';
	</script>";
	}
}
	
?>