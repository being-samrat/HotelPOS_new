<?php
include('../../db_conn/conn.php');
if($_POST['id'])
{
	$delParcel_id=$_POST['id'];
	$update_sql="UPDATE order_table SET order_open='0' WHERE parcel_id='$delParcel_id'";          
    $update_sql2="UPDATE parcel_table SET new_parcel='0',parcel_open='0' WHERE parcel_id='$delParcel_id'";          
    mysqli_query($conn,$update_sql);
    mysqli_query($conn,$update_sql2);
	
}
?>