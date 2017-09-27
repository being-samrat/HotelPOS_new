<?php 
error_reporting(E_ERROR | E_PARSE);

include_once("../../db_conn/conn.php");
$del_orderNo=$_POST['order_no'];

	$sql="DELETE FROM order_bill WHERE order_no='$del_orderNo'";
	mysqli_query($conn,$sql);

echo '<label class="w3-label w3-large">Invoice No: #'.$del_orderNo.' is deleted!!!</label>';

?>
