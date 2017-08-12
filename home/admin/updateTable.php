<?php
include('../db_conn/conn.php');
if($_POST['id'])
{
	$delTable_id=$_POST['id'];
	$sql="UPDATE hotel_tables SET occupied='0' WHERE table_id='$id'";
	mysqli_query($conn,$sql);
	
	
}
?>