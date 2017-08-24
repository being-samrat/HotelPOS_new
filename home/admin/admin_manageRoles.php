<?php
session_start();
if(!isset($_SESSION['admin_passwd']))
{
	
	header("location:../index.php");
}
?>
<?php
include_once("../db_conn/conn.php");
$err="";
$success="";
$chngeerr="";

// script to change waiter password
if(isset($_POST['waiter_password']))
{	
	$waiter_role_password=$_POST['waiter_role_password'];
	$waiter_confirm_role_password=$_POST['waiter_confirm_role_password'];	

	if ($waiter_role_password != $waiter_confirm_role_password) {
		$chngeerr="Confirm password did not match!!!<br>";
	}	
	
	else{
		$sql="UPDATE user_login SET password='$waiter_role_password' WHERE role='Waiter'";
		mysqli_query($conn,$sql);
	}
}

// script to change cashier password
if(isset($_POST['cashier_password']))
{	
	$cashier_role_password=$_POST['cashier_role_password'];
	$cashier_confirm_role_password=$_POST['cashier_confirm_role_password'];	

	if ($cashier_role_password != $cashier_confirm_role_password) {
		$chngeerr="Confirm password did not match!!!<br>";
	}	
	
	else{
		$sql="UPDATE user_login SET password='$cashier_role_password' WHERE role='Cashier'";
		mysqli_query($conn,$sql);
	}
}

// script to change customer password
if(isset($_POST['customer_password']))
{	
	$customer_role_password=$_POST['customer_role_password'];
	$customer_confirm_role_password=$_POST['customer_confirm_role_password'];	

	if ($customer_role_password != $customer_confirm_role_password) {
		$chngeerr="Confirm password did not match!!!<br>";
	}	
	
	else{
		$sql="UPDATE user_login SET password='$customer_role_password' WHERE role='Customer'";
		mysqli_query($conn,$sql);
	}
}

// script to change value password field as dropdown select
if(isset($_POST['role']))
{
	$role=$_POST['role'];
	$sql="SELECT * FROM user_login WHERE role='$role'";
	$result=mysqli_query($conn,$sql);
	$role_password="";
	while($row = mysqli_fetch_array($result)) {
		$role_password=$row['password'];
	}
	echo $role_password;
	die();
}

// script to submit add role form
if(isset($_POST['submit']))
{	
	$uname=$_POST['role_name'];
	$passwd=$_POST['role_passwd'];
	$choose_role=$_POST['choose_role'];
	$sql="SELECT * FROM user_login WHERE username='$uname' AND role='$choose_role'";
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
		$success=" ".$choose_role." ".$uname." Added!!!<br>";
		header("Location:admin_manageRoles.php");

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
						<label class="w3-label ">Choose Role: </label>
						<select class="form-control w3-margin-bottom" id="choose_role" name="choose_role" required>
							<option class="w3-red">Select User Role</option>
							<option>Cashier</option>
							<option>Waiter</option>
						</select>

						<label class="w3-label">Username: </label>
						<input type="text" class="form-control w3-margin-bottom" name="role_name" placeholder="enter unique name" required>

						<label class="w3-label">Password: </label>
						<input type="text" maxlength="10" class="form-control " placeholder="enter password of max.10 chars" id="role_passwd" name="role_passwd" >			
						<span class="w3-small w3-text-red w3-margin-bottom">NOTE: Password will remain common for the respective roles</span><br>			
						<span class="w3-text-green"><?php echo $success; ?></span>
						<button type="submit" name="submit" class="w3-round btn w3-red w3-margin-top">Add Role</button>
					</form>

				</div>
			</div>
			<div class="w3-col l7 well">

				<div class="w3-container w3-padding-16" >
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#waiter">Waiters </a></li>
						<li><a data-toggle="tab" href="#cashier">Cashiers </a></li>
						<li><a data-toggle="tab" href="#customer">Customer </a></li>
					</ul>

					<div class="tab-content">
						<div id="waiter" class="tab-pane fade in active">
							<?php 	
							$waiter_pass="";

							$sql="SELECT * FROM user_login WHERE role='Waiter'";
							$result = mysqli_query($conn,$sql);

							echo '<table class="table table-bordered w3-margin-top table-striped w3-card-2 w3-col l5" >
							<thead>
								<tr>
									<th class="w3-center">UserName</th>									
									<th class="w3-center">Action</th>
								</tr>
							</thead>
							<tbody class="w3-center">';
								while($row = mysqli_fetch_array($result)) {
									$waiter_pass=$row['password'];

									echo '
									<tr>
										<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['username'].'" readonly></td>										
										<td><a class="w3-margin-24" title="Delete User" href="removeUser.php?user_id='.$row['user_id'].'"><i class="fa fa-user-times"> Delete</i></a>
										</td>
									</tr>';

								}

								echo '</tbody>
							</table>';
							

							?> 
							<div class="w3-container w3-col l6" >
								<label class="w3-text-red"><?php echo $chngeerr; ?></label>
								<form method="POST" action="#">								
									<label class=" w3-medium">Password: 

										<input type="text" class="form-control w3-margin-bottom" name="waiter_role_password" value="<?php echo $waiter_pass; ?>"></label>

										<label class=" w3-medium">Confirm Password: 
											<input type="text" maxlength="10" class="form-control w3-margin-bottom" placeholder="enter same password as above" id="confirm_role_password" name="waiter_confirm_role_password" required>	</label>					

											<button type="submit" name="waiter_password" class="w3-round btn w3-red">Change Waiter Password</button>
										</form>
									</div> 
								</div>
								<div id="cashier" class="tab-pane fade">

									<?php 	
									$cashier_pass="";

									$sql="SELECT * FROM user_login WHERE role='Cashier'";
									$result = mysqli_query($conn,$sql);

									echo '<table class="table table-bordered w3-margin-top table-striped w3-card-2 w3-col l5" >
									<thead>
										<tr>
											<th class="w3-center">UserName</th>
											<th class="w3-center">Action</th>
										</tr>
									</thead>
									<tbody class="w3-center">';
										while($row = mysqli_fetch_array($result)) {
											$cashier_pass=$row['password'];

											echo '
											<tr>
												<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['username'].'" readonly></td>

												<td><a class="w3-margin-24" title="Delete User" href="removeUser.php?user_id='.$row['user_id'].'"><i class="fa fa-user-times"> Delete</i></a>
												</td>
											</tr>';

										}

										echo '</tbody>
									</table>';
									

									?>
									<div class="w3-container w3-col l6 w3-margin-left">
										<label class="w3-text-red"><?php echo $chngeerr; ?></label>
										<form method="POST" action="#">								
											<label class=" w3-medium">Password: 

												<input type="text" class="form-control w3-margin-bottom" name="cashier_role_password" value="<?php echo $cashier_pass; ?>"></label>

												<label class=" w3-medium">Confirm Password: 
													<input type="text" maxlength="10" class="form-control w3-margin-bottom" placeholder="enter same password as above" id="confirm_role_password" name="cashier_confirm_role_password">	</label>					

													<button type="submit" name="cashier_password" class="w3-round btn w3-red">Change Cashier Password</button>
												</form>
											</div>  
										</div>
										<div id="customer" class="tab-pane fade in">
											<?php 	
											$customer_pass="";

											$sql="SELECT * FROM user_login WHERE role='Customer'";
											$result = mysqli_query($conn,$sql);
											while($row = mysqli_fetch_array($result)) {
												$customer_pass=$row['password'];							

											}
											mysqli_close($conn);
											?> 
											<div class="w3-container w3-col l6 w3-margin-left" >
												<label class="w3-text-red"><?php echo $chngeerr; ?></label>
												<form method="POST" action="#">								
													<label class=" w3-medium">Password: 

														<input type="text" class="form-control w3-margin-bottom" name="customer_role_password" value="<?php echo $customer_pass; ?>"></label>

														<label class=" w3-medium">Confirm Password: 
															<input type="text" maxlength="10" class="form-control w3-margin-bottom" placeholder="enter same password as above" id="confirm_role_password" name="customer_confirm_role_password">	</label>					

															<button type="submit" name="customer_password" class="w3-round btn w3-red">Change Customer Password</button>
														</form>
													</div> 
												</div>						
											</div>

										</div>

									</div>
								</div>
							</div>
							<!--  -->


<script>

// SELECT BOX DEPENDENCY CODE
$(document).ready(function()
{
	$("#choose_role").change(function()
	{
		var role=$(this).val();
		var dataString = 'role='+ role;

		$.ajax
		({
			type: "POST",
			url: "admin_manageRoles.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#role_passwd").val(html);
			} 
		});
	});
});
</script>
</body>
</html>