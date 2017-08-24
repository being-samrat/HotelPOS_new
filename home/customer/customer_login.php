<html>
<body>

	<?php 
	session_start();

	$name=$_POST["cust_name"];
	$passwd=$_POST["cust_passwd"];

	$sql="SELECT * FROM user_login WHERE username='$name' and password='$passwd'";
	$result=mysqli_query($conn,$sql);

// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	if ($count == 1) {

		$_SESSION['custom']=$name;
		header("location:customer_home.php");
		
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
	
?>

</body>
</html>
