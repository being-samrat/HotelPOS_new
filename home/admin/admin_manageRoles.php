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
	$sql="SELECT * FROM user_login WHERE username='$uname'";
	$result=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($result);

	if ($count > 0) {
		$err="Username exists!!! Try different<br>";
	}
	
	elseif(($_POST['choose_role'])=='Select User Role')
	{
		$err="Please select Appropriate role!!!<br>";
	}
	else{
		$sql="INSERT INTO user_login(role,username, password) VALUES('".$choose_role."','".$uname."','".$passwd."')";
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
						
						<label class="w3-label ">Choose Role: </label>
						<select class="form-control w3-margin-bottom" name="choose_role" required>
							<option>Select User Role</option>
							<option>Cashier</option>
							<option>Waiter</option>
						</select>
						<button type="submit" name="submit" class="w3-round btn w3-red">Add Role</button>
					</form>

				</div>
			</div>
			<div class="w3-col l7 well">

				<div class="w3-container w3-padding-16" >
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#waiter">Waiters List</a></li>
						<li><a data-toggle="tab" href="#cashier">Cashiers List</a></li>
					</ul>

					<div class="tab-content">
						<div id="waiter" class="tab-pane fade in active">
							<br>
							<?php 	

							$sql="SELECT * FROM user_login WHERE role='Waiter'";
							$result = mysqli_query($conn,$sql);

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
										<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['username'].'" readonly></td>
										<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_passwd" value="'.$row['password'].'" readonly></td>
										<td><a class="w3-margin-24" title="Delete User" href="removeUser.php?user_id='.$row['user_id'].'"><i class="fa fa-user-times"> Delete</i></a>
										</td>
									</tr>';

								}

								echo '</tbody>
							</table>';
							

							?>  
						</div>
						<div id="cashier" class="tab-pane fade">
							<br>
							<?php 	

							$sql="SELECT * FROM user_login WHERE role='Cashier'";
							$result = mysqli_query($conn,$sql);

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
										<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['username'].'" readonly></td>
										<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_passwd" value="'.$row['password'].'" readonly></td>
										<td><a class="w3-margin-24" title="Delete User" href="removeUser.php?user_id='.$row['user_id'].'"><i class="fa fa-user-times"> Delete</i></a>
										</td>
									</tr>';

								}

								echo '</tbody>
							</table>';
							mysqli_close($conn);

							?>  
						</div>						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!--  -->



</body>
</html>