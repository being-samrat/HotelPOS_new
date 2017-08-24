<?php
session_start();
include_once("db_conn/conn.php");

extract($_POST);
// print_r($_POST);
// die();
if(isset($_POST['admin_submit']))
{
	$sql="SELECT * FROM user_login WHERE username='$admin_name' AND password='$admin_passwd' AND role='Administrator'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {
		$_SESSION['admin_passwd']=$_POST['admin_passwd'];
		header("location:admin/admin_index.php");
	}
	else{
		echo '<script>alert("Wrong Username or Password!!!");
		window.location.href="index.php";
	</script>';
}

}
elseif(isset($_POST['cashier_submit']))
{
	$sql="SELECT * FROM user_login WHERE username='$cashier_name' and password='$cashier_passwd' AND role='Cashier'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {
		
		$_SESSION['cashier']=$_POST['cashier_name'];
		header("location:admin/admin_viewTable.php");
	}
	else{
		echo '<script>alert("Wrong Username or Password!!!");
		window.location.href="index.php";
	</script>';
}

}
elseif(isset($_POST['waiter_submit']))
{
	$sql="SELECT * FROM user_login WHERE username='$waiter_name' and password='$waiter_passwd' AND role='Waiter'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {
		
		$_SESSION['waiter']=$_POST['waiter_name'];
		header("location:waiter/waiter_home.php");
	}
	else{
		echo '<script>alert("Wrong Username or Password!!!");
		window.location.href="index.php";
	</script>';
}

}
elseif(isset($_POST['customer_submit']))
{
	$table_no="";
	$get_tno="SELECT * FROM hotel_tables WHERE table_id='".$table_id."'";
    $get_tno_res=mysqli_query($conn,$get_tno);
     
     
    while($row = mysqli_fetch_array( $get_tno_res))
     { 
      $table_no=$row['table_name']; //get table name from table_id.............................
     
    }

	if ($table_id !='Select Table') {
	$sql="SELECT * FROM user_login WHERE password='$customer_passwd' AND role='Customer'";
	$result=mysqli_query($conn,$sql);

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
	else{
		echo '<script>alert("Wrong Username or Password!!!");
		window.location.href="index.php";
		</script>';
		}
	}	
	else{
echo '<script>alert("Select Table First!!!");
		window.location.href="index_login.php";
		</script>';
		}


}
    
?>