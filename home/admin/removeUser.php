<?php
include_once("../db_conn/conn.php");

//--------------
if(isset($_GET['admin_id']))
{
	$id=$_GET['admin_id'];
	$query = "DELETE  from admin WHERE admin_id='$id' LIMIT 1";
	mysqli_query($conn,$query);

	if($query)
	{
		header('location:admin_manageRoles.php');
	}
}
else { 

	echo'<strong>Deletion Failed</strong><br /><br />';

} 
?>