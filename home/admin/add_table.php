<?php

include("../db_conn/conn.php");
if (isset($_POST['submit_addTab'])) {
	if ($_POST['tableNO']) {
		foreach ( $_POST['tableNO'] as $key=>$value ) {
			$values = mysqli_real_escape_string($conn,$value);
			$query_sql="INSERT INTO hotel_tables (table_name) VALUES ('$values')";
			mysqli_query($conn ,$query_sql);


		}
	}
	echo "<script>
	window.location.href='admin_manageSettings.php';
</script>";


mysqli_close($conn);
}
?>