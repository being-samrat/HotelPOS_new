<?php

include("../../db_conn/conn.php");
if (isset($_GET['parcelBy'])) {
	
$parcelBy=$_GET['parcelBy'];

			$query_sql="INSERT INTO parcel_table (parcelBy) VALUES ('$parcelBy')";
			mysqli_query($conn ,$query_sql);

			echo "<script>
	window.location.href='../parcelOrder.php';
</script>";
	}
	else{
		echo "<script>
		alert('Parcel not added !!!')
	window.location.href='../parcelOrder.php';
</script>";


	}
	
mysqli_close($conn);

?>