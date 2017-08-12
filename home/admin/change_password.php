<?php
session_start();
if(!isset($_SESSION['admin_passwd']))
{
  $_SESSION['admin']='';
  header("location:../index.php");
}
?>
<?php
include_once("../db_conn/conn.php");

$err="";

if(isset($_POST['submit']))
{	
	$uname=$_POST['role_name'];
$passwd=$_POST['role_passwd'];
	$sql="SELECT * FROM admin WHERE uname='$uname'";
	$result=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($result);

	if ($count > 0) {
		$err="Username exists!!! Try different<br>";
	}
	elseif(($_POST['role_passwd'])!=($_POST['crole_passwd']))
	{
			$err="Confirm Password did not match!!!<br>";
	}
	else{
		$sql="INSERT INTO admin(uname, passwd) VALUES('".$uname."','".$passwd."')";
		mysqli_query($conn,$sql);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>View Tables</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
	<style type="text/css">
		.table_view{
			background-image: url(adminImg/empty.png);
			background-size: 40px;
			background-repeat: no-repeat;
			background-position: left;
			background-origin: content-box;
			padding-top:15px;
		}
	</style>
</head>
<body style="background-color: #E4E4E4">
	<?php include("admin_navigation.php"); ?>
	<!--  -->
	<div class="w3-main " style="margin-left:300px;margin-top:43px;">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
		<!-- Header -->
		<header class="w3-container " style="padding-top:22px">
			<h5><b><i class="fa fa-unlock-alt"></i> Change Password</b></h5>
			<small class="w3-text-red">* Under Construction</small>
		</header>
		
		<div class="w3-row-padding w3-margin-bottom">
			<div class="w3-col l5 w3-margin-bottom ">
				<div class="w3-container w3-padding-16 w3-card-2 well">
					<form method="POST" action="change_password.php">
						<label class="w3-label">Password: </label>
						<input type="text" class="form-control w3-margin-bottom" name="admin_name" value="<?php echo $_SESSION['admin_passwd']; ?>">
						<label class="w3-label">New Password: </label>
						<input type="text" class="form-control w3-margin-bottom" name="admin_passwd" required>
						<label class="w3-label">Confirm New Password: </label>
						<input type="text" class="form-control w3-margin-bottom" name="admin_cpasswd" required>
						<button type="submit" class="w3-round btn w3-red">Change Password</button>
					</form>
					
				</div>
			</div>
	</div>
</div>
<!--  -->



</body>
</html>