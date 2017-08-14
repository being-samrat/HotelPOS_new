<?php
error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
extract($_POST);

$check_service = "0";
$check_vat = "0";

if(isset($_POST['add_Bill'])){
	if($servicecheck < 1){
		$service  = 0;
	}

	if($vatcheck < 1){
		$vat = 0;
	}
	
	$sql="UPDATE bill_struct SET hotel_name='".$hotelName."', hotel_addr='".$hotelAddr."', contact_no='".$hotelContact."', mobile_no='".$hotelContact2."', gst='".$gst."', service_tax = '".$service."', vat = '".$vat."', servicetaxname = '".$servicetax."' , vatname = '".$vatname."' , status1 = '".$servicecheck."' , status2 = '".$vatcheck."' WHERE bill_id='1'";

	if((mysqli_query($conn,$sql))==TRUE){
		echo "<script>alert('Bill Structure Updated');
		window.location.href='admin_manageSettings.php';
	</script>";
}
else {
	# code...
	mysqli_error();
}
}
mysqli_close($conn);
?>