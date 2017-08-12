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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Manage Roles</title>
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
			<h5><b><i class="fa fa-user-secret"></i> Manage Roles</b></h5>
		</header>

		<div class="w3-row-padding w3-margin-bottom">
			<div class="w3-col l5 w3-margin-bottom well">
				<div class="w3-container w3-col l11 w3-padding-16">
					<form method="POST" action="#">
						<span class="w3-text-red"><?php echo $err; ?></span>
						<label class="w3-label">Username: </label>
						<input type="text" class="form-control w3-margin-bottom" name="role_name" placeholder="enter unique name" required>

						<label class="w3-label">Password: </label>
						<input type="password" maxlength="10" class="form-control w3-margin-bottom" placeholder="enter password of max.10 chars" name="role_passwd" required>

						<label class="w3-label">Confirm Password: </label>
						<input type="password" maxlength="10" class="form-control w3-margin-bottom" placeholder="re-enter same password " name="crole_passwd" required>
						<button type="submit" name="submit" class="w3-round btn w3-red">Add Role</button>
					</form>

				</div>
			</div>
			<div class="w3-col l7 w3-margin-bottom well">

				<div class="w3-container w3-padding-16 w3-right" >
					<?php 	

					$sql="SELECT * FROM admin";
					$result = mysqli_query($conn,$sql);
//echo '<select class="form-control w3-margin"  style="width: 40%" >';

					echo '<table class="table table-bordered table-striped w3-card-2" >
					<thead>
						<tr>
							<th class="w3-center">UserName</th>
							<th class="w3-center">Password</th>
							<th class="w3-center">Action</th>
						</tr>
					</thead>
					<tbody class="w3-center">';
						while($row = mysqli_fetch_array($result)) {
							echo '

							<tr>
								<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['uname'].'"></td>
								<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_passwd" value="'.$row['passwd'].'"></td>
								<td><a class="w3-margin-24" href="removeUser.php?admin_id='.$row['admin_id'].'"><i class="fa fa-user-times"> Delete</i></a>
								</td>
							</tr>

							';


						}

						echo '</tbody>
					</table>';

//echo "</select>";
					mysqli_close($conn);

					?>  
				</div>
			</div>
		</div>
	</div>
	<!--  -->



</body>
</html>