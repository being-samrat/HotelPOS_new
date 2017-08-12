<?php
include('../../db_conn/conn.php');
if($_POST['id'])
{
	$delParcel_id=$_POST['id'];
	$sql="DELETE FROM parcel_table WHERE parcel_id='$delParcel_id'";
	mysqli_query($conn,$sql);
	echo 'Parcel No: '.$delParcel_id.' deleted!!!';
	
}
?>