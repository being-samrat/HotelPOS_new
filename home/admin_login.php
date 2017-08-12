<?php
session_start();
include_once("db_conn/conn.php");

extract($_POST);

switch ($role) {
	case 'Administrator':

	if(!isset($_POST['table_submit']))
	{
		
	}
	else{
		if($_POST['admin_name']=='admin' && $_POST['admin_passwd']=='admin'){
			$_SESSION['admin_passwd']=$_POST['admin_passwd'];
			header("location:admin/admin_index.php");
		}
		else{
			echo '<script>alert("Wrong Username or Password!!!");
			window.location.href="index.php";
		</script>';
	}
}
break;
case 'Cashier':

if(!isset($_POST['table_submit']))
{
	
}
else{
	$sql="SELECT * FROM admin WHERE uname='$admin_name' and passwd='$admin_passwd'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {
		
		$_SESSION['cashier']=$_POST['admin_name'];
		header("location:admin/admin_viewTable.php");
	}
	else{
		echo '<script>alert("Wrong Username or Password!!!");
		window.location.href="index.php";
	</script>';
}
}
break;
default:
echo '<script>alert("Select option first!!!");
		window.location.href="index.php";
	</script>';
}    
?>