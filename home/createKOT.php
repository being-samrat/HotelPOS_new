
<?php 
// if(isset($_REQUEST))
// {
// $table_id= "-1";
// $table_no= "-1";
include_once("db_conn/conn.php");
$table_id = $_POST['table_id'];
$table_no = $_POST['table_no'];
$date=date("Y-m-d");

$sql="INSERT INTO kot_table(kot_id,table_id,table_no,kot_items,date_time,print_status) VALUES ('','".$table_id."','".$table_no."','','".$date."','1')";
$result=mysqli_query($conn,$sql);
$table_name="";

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

	$order_status="SELECT * FROM order_table WHERE table_no='$table_no' AND order_open='1'";
	$order_status_result=mysqli_query($conn,$order_status);
	$kot="";
	$table_name=mysqli_num_rows($order_status_result);
	 if ($table_name == 0) 
	{
		$create_order="INSERT INTO order_table(order_id,table_id,table_no,total_kot,ordered_items,date_time,order_open) VALUES ('','".$table_id."','".$table_no."','','','".$date."','1')";
		$create_order_result=mysqli_query($conn,$create_order);
	}
	else{
			
	}

	
$occu_sql="UPDATE hotel_tables SET occupied='1',kot_open='1' WHERE table_id='$table_id'";
mysqli_query($conn,$occu_sql);
}
else{
	echo mysqli_error($conn);
	echo "Insertion Failed"; 
}
mysqli_close($conn);


?>