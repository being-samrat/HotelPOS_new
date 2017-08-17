<?php 
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('Asia/Kolkata');

include_once("../../db_conn/conn.php");
$order_id=$_POST['order_id'];
$bill_amt=$_POST['bill_amt'];
$parcel_id=$_POST['id'];

if (($_POST['order_id'])!='' && ($_POST['bill_amt'])!='') {
	$dated=date("d/m/Y");
	$time=date("h:i a");

	//code to check order already exists in table...
	$chkBill_exist_sql="SELECT * FROM order_bill WHERE order_no='$order_id'";
	$chkBill_exist_sql_result=mysqli_query($conn,$chkBill_exist_sql);
	$bill_count=mysqli_num_rows($chkBill_exist_sql_result);
	if ($bill_count == 0) 
	{
		$saveBill_sql="INSERT INTO order_bill (order_no,table_id,revenue,dated ,time_at) VALUES ('$order_id','$id','$bill_amt','$dated','$time')";
		mysqli_query($conn ,$saveBill_sql);
		echo '<label class="w3-label w3-large">Order No.'.$order_id.' is saved!!!</label>';

		$print_ready_sql="UPDATE order_bill SET readyTo_print='1' WHERE order_no='$order_id'";
		mysqli_query($conn ,$print_ready_sql);
	}
	else{
		//if order exists, then just update modified revenue
		$saveBill_sql="UPDATE order_bill SET revenue='$bill_amt', dated='$dated' WHERE order_no='$order_id'";
		mysqli_query($conn ,$saveBill_sql);
		echo '<label class="w3-label w3-large">Order No.'.$order_id.' updated!!!</label>';

		$print_ready_sql="UPDATE order_bill SET readyTo_print='1' WHERE order_no='$order_id'";
		mysqli_query($conn ,$print_ready_sql);
	}
	
		
}
else{
	echo " ".mysqli_error();
}


?>
