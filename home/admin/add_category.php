<?php
error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
$new_category=$_POST['new_category'];

$sql="SELECT * FROM menu_category WHERE LOWER(cat_name)=LOWER('".$new_category."')";
$result=mysqli_query($conn,$sql);
$count=mysqli_num_rows($result);

if ($count > 0) {
	echo "<script>alert('Menu Category already exist!!! Try different');
	window.location.href='admin_manageSettings.php';
	</script>";
	
}
else{
	$newcat_sql="INSERT INTO menu_category(cat_name) VALUES('".$new_category."')";

	if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
		echo "<script>
		window.location.href='admin_manageSettings.php';
	</script>";
}
else
{
	echo "Insertion Failed ".mysqli_error($conn);
}
}
mysqli_close($conn);
?>