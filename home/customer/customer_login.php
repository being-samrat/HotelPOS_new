<html>
<body>

	<?php 
	$name=$_POST["cust_name"];
	$passwd=$_POST["cust_passwd"];
	if($name=='custom' && $passwd=='custom'){
		header("location:demo.php");
	
		session_start();
				$_SESSION['custom']=$name;

		
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
		echo '<script>alert("wrong uname and password!");</script>';
		header("Location: index.php");
	}
	?>

</body>
</html>
