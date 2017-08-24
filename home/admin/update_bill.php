<?php
error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
extract($_POST);

if(isset($_POST['add_Bill'])){
	if($tax1_check < 1){
		$tax1_val  = 0;
	}

	if($tax2_check < 1){
		$tax2_val = 0;
	}
	
	$sql="UPDATE bill_struct SET hotel_name='".$hotelName."', hotel_addr='".$hotelAddr."', contact_no='".$hotelContact."', mobile_no='".$hotelContact2."', gst='".$gst."', tax1_value = '".$tax1_val."', tax2_value = '".$tax2_val."', tax1_name = '".$tax1_name."' , tax2_name = '".$tax2_name."' , tax1_status = '".$tax1_check."' , tax2_status = '".$tax2_check."' WHERE bill_id='1'";

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