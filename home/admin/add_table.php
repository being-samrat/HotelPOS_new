<?php
error_reporting(E_ERROR | E_PARSE);
include("../db_conn/conn.php");
if (isset($_POST['submit_addTab'])) {

	

	if ($_POST['tableNO']) {
		
		$check = $_POST['tableAC'];
//echo $check
		foreach ( $_POST['tableNO'] as $key=>$value ) {
			$table_name =  $_POST['tableNO'];
			$values = mysqli_real_escape_string($conn,$value);
			$query_sql="INSERT INTO hotel_tables (table_name , status) VALUES ('$values','$check')";
			mysqli_query($conn ,$query_sql);

		}
	}
	echo "<script>
	window.location.href='admin_manageSettings.php';
</script>";


mysqli_close($conn);
}
?>