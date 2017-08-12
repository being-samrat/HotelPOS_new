<?php
include('../db_conn/conn.php');
//echo "hello";
if($_POST['item_id'])
{
	$id=$_POST['item_id'];
	$disable_item=$_POST['disable_item'];
	$sql="UPDATE menu_items SET item_status='1' WHERE item_id='$id'";
	mysqli_query($conn,$sql);

}
	
?>