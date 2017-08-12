<?php 
// if(isset($_REQUEST))
// {
include_once("db_conn/conn.php");
$table_id = $_POST['table_id'];
//$table_no = $_POST['table_no'];

echo $table_id;
$sql = "SELECT * FROM hotel_tables WHERE table_id='$table_id'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	if($row['reserved'] == 1){
		$sql="UPDATE hotel_tables SET reserved='0' WHERE table_id='$table_id'";
		$result = mysqli_query($conn,$sql);
	}
	else if($row['reserved'] == 0){
		$sql="UPDATE hotel_tables SET occupied='1',reserved='1' WHERE table_id='$table_id'";
		$result = mysqli_query($conn,$sql);
	}
}




//$sql = "UPDATE hotel_tables set  occupied='0',reserved='0' where table_id='$table_id'";

//$result = mysqli_query($conn,$sql);
?>
