<?php
//error_reporting(E_ERROR | E_PARSE);
session_start();

include_once("db_conn/conn.php");
?>
	<?php 
	$table_id=$_POST["table_ID"];
	$table_no=$_GET["table_NO"];
	$password=$_POST["customer_password"];
	
	$sql="SELECT * FROM user_login WHERE password='$password' AND role='Customer'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {

		$_SESSION['customer_table']=$table_id;

		$date=date("Y-m-d");

		$sql="INSERT INTO kot_table(kot_id,table_id,table_no,kot_items,date_time,print_status) VALUES ('','".$table_id."','".$table_no."','','".$date."','1')";
		$result=mysqli_query($conn,$sql);
		$table_name="";

		if($result){

		$order_status="SELECT * FROM order_table WHERE table_id='$table_id' AND order_open='1'";
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
	header("Location: customer/customer_home.php");


		// if (isset($_COOKIE[$id]))
		// {
		// 	if($_COOKIE[$id]=="Mobile")
		// 	{
		// 		header("Location: mobile.php");
		// 	}
		// 	else if($_COOKIE [$id]=="Tv")
		// 	{
		// 		header("Location: tv.php");
		// 	}
		// 	else if($_COOKIE [$id]=="Headphone")
		// 	{
		// 		header("Location: headphone.php");
		// 	}
		// 	else if($_COOKIE[$id]=="Laptop")
		// 	{
		// 		header("Location: laptop.php");
		// 	}
		// }
		// else
		// {
		// 	header("Location: first.php");
		// }
}
else
{
	echo '<script>alert("Wrong Username or Password!!!");
	window.location.href="index.php";
</script>';
		//header("Location: index.php");
}
?>

