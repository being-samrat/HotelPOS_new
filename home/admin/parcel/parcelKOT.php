
<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
date_default_timezone_set('Asia/Kolkata');

$user="";
if(isset($_SESSION['admin_passwd']))
{
	$user=$_SESSION['admin_passwd'];
}
else{
	$user=$_SESSION['cashier'];
}

include_once("../../db_conn/conn.php");
$parcel_id = $_POST['parcel_id'];
$date=date("Y-m-d");

$sql="INSERT INTO kot_table(kot_id,table_id,table_no,kot_items,date_time,print_status,parcel_id) VALUES ('','-1','-1','','".$date."','1','".$parcel_id."')";
$result=mysqli_query($conn,$sql);
$count="";

if($result){

	echo '<div class="alert alert-success w3-margin-bottom">
	<strong>KOT ADDED!</strong> 
</div>
<script>
	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 900);
</script>';

$order_status="SELECT * FROM order_table WHERE parcel_id='$parcel_id'";
$order_status_result=mysqli_query($conn,$order_status);
$kot="";
$count=mysqli_num_rows($order_status_result);
if ($count == 0) 
{
	$create_order="INSERT INTO order_table(order_id,table_id,table_no,total_kot,ordered_items,date_time,order_open,parcel_id) VALUES ('','-1','-1','','','".$date."','1','".$parcel_id."')";
	$create_order_result=mysqli_query($conn,$create_order);
}
else{

}
$occu_sql="UPDATE parcel_table SET new_parcel='0',parcel_open='1' WHERE parcel_id='$parcel_id'";
mysqli_query($conn,$occu_sql);
}

else{
	echo mysqli_error($conn);
	echo " KOT Insertion Failed"; 
}
mysqli_close($conn);


?>