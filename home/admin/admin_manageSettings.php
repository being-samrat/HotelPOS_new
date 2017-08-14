<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
if(!isset($_SESSION['admin_passwd']))
{
	$_SESSION['admin']='';
	header("location:../index.php");
}
?>
<?php
include_once("../db_conn/conn.php")
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Manage Settings</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
		<link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">

	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>

	<script>
		$(document).ready(function() {
			var max_fields      = 10;
			var wrapper         = $(".addTable_container"); 
			var add_button      = $(".add_form_field"); 

			var x = 1; 
			$(add_button).click(function(e){ 
				e.preventDefault();
				if(x < max_fields){ 
					x++; 
            $(wrapper).append('<div><label>Table No: </label>&nbsp;<input type="text" autocomplete="off" name="tableNO[]" style="width: 80px;" required/><a href="#" class="delete w3-grey w3-margin-left fa fa-remove w3-padding-tiny w3-text-white" title="Delete table"></a></div>'); //add input box
            
        }
        else
        {
        	alert('You Reached the limits')
        }
    });

			$(wrapper).on("click",".delete", function(e){ 
				e.preventDefault(); $(this).parent('div').remove(); x--;
			})
		});
	</script>
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

	<div class="w3-main " style="margin-left:300px;margin-top:43px;">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
		<!-- Header -->
		<header class="w3-container " style="padding-top:22px">
			<h5><b><i class="fa fa-edit"></i> Manage Tables</b></h5>
		</header>

		<div class="w3-row-padding w3-margin-bottom">
			<?php  
			$fetch_tables="SELECT * FROM hotel_tables ORDER BY table_name";
			$fetch_tables_result=mysqli_query($conn,$fetch_tables);
			
			
			while($row = mysqli_fetch_array( $fetch_tables_result))
			{
				$occupied_chk="unchecked";
				$reserved_chk="unchecked";
				$color="";
				$hide="";

				if (($row['join_id']==0)) {
									# code...
					$hide="w3-hide";
				}

				if (($row['occupied']==1)) {
									# code...
					$occupied_chk="checked";
					$color="#ff9800";

					if (($row['join_id']=='-1')) {
						$color="#79E40D";
					}
				}
				if (($row['reserved']==1)) {
									# code...
					$occupied_chk="checked";
					$reserved_chk="checked";
					$color="#79E40D";
				}
				
				echo '
				<div class="w3-col l3 w3-col m3 w3-col s6 w3-margin-bottom '.$hide.'">
					<button type="button" class="close w3-padding-tiny w3-text-black" onclick="delTable('.$row['table_id'].')">&times;</button>
					<div class="w3-container w3-red w3-padding-16 w3-card-8 w3-round-large">
						<div class="w3-left w3-circle w3-padding-small" id="'.$row['table_id'].'" style="border:4px solid '.$color.';"><span class="w3-large">#'.$row['table_name'].'</span></div>
						<div class="w3-right w3-xsmall ">
							<span>
								<label class="w3-medium w3-margin-right">
									<input type="checkbox" name="table_stat[]" value="1" '.$occupied_chk.' disabled> Occupied
								</label><br>
								<label class="w3-medium w3-margin-right">
									<input type="checkbox" name="table_stat[]" value="1" '.$reserved_chk.' disabled> Reserved
								</label>
							</span>          
						</div>

					</div>
				</div>';

			}   

			?>

		</div>

		<button type="button" class="btn w3-card w3-round-xlarge w3-text-red w3-margin-left" data-toggle="modal" data-target="#addTable"><span class="fa fa-plus"></span> Add New Table</button>


		<!-- Modal -->
		<div id="addTable" class="modal fade " role="dialog">
			<div class="modal-dialog ">
				<!-- Modal content-->
				<div class="modal-content col-lg-6 col-lg-offset-4">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button><br>
						<div class="w3-center">
							<button class="add_form_field btn w3-card w3-round-xlarge w3-text-red w3-margin-bottom">Add New Table <span class="fa fa-plus"></span> <span style="font-size:10px; font-weight:bold;"> (max. 10)</span></button>
						</div>
					</div>
					<div class="modal-body">
						<form method="POST" action="add_table.php">
							<div class="addTable_container w3-center w3-margin-bottom"></div><hr>
							
							<center><input type="checkbox" name="tableAC" title="Make table A/C" value="1">&nbsp;<label>Check to make A/C</label>

								<button class="btn w3-red w3-button form-control" type="submit" id="submit_addTab" name="submit_addTab">Submit</button></center>
							</form>

						</div>
					</div>
				</div>
			</div>
			<!--modal end-->
			<div id="deleteMsg"></div>

			<header class="w3-container" >
				<hr class="w3-border">
				<h5><b><i class="fa fa-list"></i> Manage Menu Card</b></h5>
			</header>
			<div>
				<div class="col-lg-6">
					<form class="w3-form w3-col l12 w3-col s12 " name="admin_menu_card" id="admin_menu_card" method="POST">

						<select class="form-control" name="menu_category" style="" id="menu_category" style="width: 100px;">
							<option class="w3-red" selected>Select Category</option>
							<?php 								
							$cat_sql="SELECT DISTINCT * FROM menu_category ORDER BY cat_name ";
							$cat_sql_result=mysqli_query($conn,$cat_sql);

							while($cat_sql_row = mysqli_fetch_array( $cat_sql_result))
							{
								echo '<option value="'.$cat_sql_row['cat_name'].'">'.strtoupper($cat_sql_row['cat_name']).'</option>';
							}   


							?>  
						</select>
						<button type="button" class="btn w3-card w3-right w3-text-red" title="Delete Category" data-toggle="modal" data-target="#deletecategory"><span class="fa fa-remove"></span></button>
					</form>	
					<button type="button" class="btn w3-card w3-round-xlarge w3-margin-left w3-text-red" data-toggle="modal" data-target="#addCategory"><span class="fa fa-plus"></span> Add Category</button>

					<button type="button" class="btn w3-card w3-round-xlarge w3-text-red" data-toggle="modal" data-target="#addMenuItem"><span class="fa fa-plus"></span> Add New Item</button>

					<div id="deletecategory" class="modal fade " role="dialog">
						<div class="modal-dialog ">
							<!-- Modal content-->
							<div class="modal-content col-lg-8 col-lg-offset-2">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title w3-xxlarge w3-text-red">Delete Category</h4>
								</div>
								<div class="modal-body">
									<form id="form_delete_category" action="delete_category.php" method="POST">
										<select class="form-control w3-col 4 w3-margin-bottom" name="cat_id" style="" id="cat_id" required>
											<option class="w3-red" selected>Select Category</option>
											<?php 								
											$cat_sql2="SELECT DISTINCT * FROM menu_category ORDER BY cat_name ";
											$cat_sql_result2=mysqli_query($conn,$cat_sql2);

											while($cat_sql_row2 = mysqli_fetch_array( $cat_sql_result2))
											{
												echo '<option value="'.$cat_sql_row2['cat_id'].'">'.strtoupper($cat_sql_row2['cat_name']).'</option>';
											}
											?>  
										</select>
										<button type="submit" class="form-control btn btn-default w3-red w3-margin-bottom" name="newcat_submit" id="newcat_submit" onclick="return confirm('Confirm to delete category!');"> Delete Category </button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal -->
					<div id="addCategory" class="modal fade " role="dialog">
						<div class="modal-dialog ">
							<!-- Modal content-->
							<div class="modal-content col-lg-8 col-lg-offset-2">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title w3-xxlarge w3-text-red">Add Category</h4>
								</div>
								<div class="modal-body">
									<form id="form_add_category" action="add_category.php" method="POST">
										<input class="input form-control" type="text" id="new_category" name="new_category" placeholder="Category name" required/><br>

										<button type="submit" class="form-control btn btn-default w3-red w3-margin-bottom" name="newcat_submit" id="newcat_submit" onclick="return confirm('Confirm to add new category!');"> Add </button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!--modal end-->		

					<!-- Modal -->
					<div id="addMenuItem" class="modal fade " role="dialog">
						<div class="modal-dialog ">
							<!-- Modal content-->
							<div class="modal-content col-lg-8 col-lg-offset-2">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title w3-xxlarge w3-text-red">Add Menu Item</h4>
								</div>
								<div class="modal-body">
									<form id="form_addItem" action="insert_menuItem.php" method="POST">

										<select class="form-control w3-col 4 w3-margin-bottom" name="cat_id" style="" id="cat_id" required>
											<option class="w3-red" selected>Select Category</option>
											<?php 								
											$cat_sql2="SELECT DISTINCT * FROM menu_category ORDER BY cat_name ";
											$cat_sql_result2=mysqli_query($conn,$cat_sql2);

											while($cat_sql_row2 = mysqli_fetch_array( $cat_sql_result2))
											{
												echo '<option value="'.$cat_sql_row2['cat_id'].'">'.strtoupper($cat_sql_row2['cat_name']).'</option>';
											}
											?>  
										</select>
										<input type="text" name="new_itemName" id="new_itemName" class="form-control w3-margin-bottom" placeholder="Item Name" required>
										<input type="number" name="new_itemPrice" id="new_itemPrice" class="form-control w3-left w3-margin-bottom" placeholder="Price" style="margin:0px; width: 120px;" required/><br>
										<hr>

										<input type="checkbox" name="menuAC" value="1">&nbsp;<label>Check to make A/c Menu Item</label>

										<button class="form-control btn btn-default w3-red w3-center w3-margin-bottom" id="add_menuItem" type="submit" onclick="return confirm('Confirm to add new Menu Item!');">Add <i class="fa fa-angle-double-right"></i>
										</button>

									</form>
								</div>
							</div>
						</div>
					</div>
					<!--modal end-->				
				</div>
				<div class="col-lg-6">
					<div class="col-lg-12 w3-margin" id="menu_item" name="menu_item">

					</div>			
				</div>
			</div>


		</div>
		<!--  -->


		<div class="w3-main " style="margin-left:300px;margin-top:43px;">
			<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
			<!-- Header -->

			<header class="w3-container " style="padding-top:22px">
				<hr class="w3-border">
				<h5><b><i class="fa fa-edit"></i> Manage Bill Structure</b></h5>
			</header>
			<div class="col-lg-6">
				<div class="col-lg-12 w3-margin">

					<?php 								
					$bill_data="SELECT * FROM bill_struct";
					$bill_data_res=mysqli_query($conn,$bill_data);

					while($row = mysqli_fetch_array( $bill_data_res))
					{ 
						$chk_tax1="";
						$chk_tax2="";
						if(($row['status1'])==1){
							$chk_tax1="checked";
						}
						if(($row['status2'])==1){
							$chk_tax2="checked";
						}
						

						?>
						<form method="POST" action="update_bill.php" style="margin-left:-30px;">
							<label for="hotelName" class="w3-margin-left">Hotel Name: </label><input type="text" class="form-control w3-margin-bottom w3-margin-left" id="hotelName" name="hotelName" placeholder="Enter Hotel Name" value="<?php echo $row['hotel_name']; ?>">
							<label for="hotelAddr" class="w3-margin-left">Address: </label><input type="text" placeholder="Enter Hotel Address " class="form-control w3-margin-bottom w3-margin-left" name="hotelAddr" id="hotelAddr" value="<?php echo $row['hotel_addr']; ?>">
							<div class="col-lg-6">
								<label for="hotelContact">Contact No: </label><input type="number" class="form-control w3-margin-bottom" id="hotelContact" name="hotelContact" placeholder="020" maxlength="10" value="<?php echo $row['contact_no']; ?>">
							</div>
							<div class="col-lg-6">
								<label for="hotelContact2">Mobile No: </label><input type="number" class="form-control w3-margin-bottom" id="hotelContact" name="hotelContact2" placeholder="020" maxlength="10" value="<?php echo $row['contact_no']; ?>">
							</div>
							
							<div class="col-lg-6">
								<label for="gstno">GST No: </label><input type="text" name="gst" id="gst" class="form-control " maxlength="10" value="<?php echo $row['gst'];  ?>">
							</div>

							<div class="col-lg-8 w3-margin-top">
								<table >                        
									<tr>
										<td>              
											<input type="checkbox" name="servicecheck" value="1" <?php echo $chk_tax1; ?>><label for="taxname1">TAX-1 Name</label>
										</td>
									</tr>
									<tr>
										<td>              
											<input type="text" name="servicetax" id="servicetax" class="form-control " style="width: 100px" placeholder="" value="<?php echo $row['servicetaxname']; ?>">
										</td>                        
										<td>
											<input type="number" name="service" id="service" class="w3-margin-left form-control " style="width: 80px" placeholder="" value = "<?php echo $row['service_tax']; ?>">
										</td>
									</tr>
									<tr> 
										<td>              
											<input type="checkbox" name="vatcheck" value = '1' <?php echo $chk_tax2; ?>><label for="taxname2">TAX-2 Name</label>
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="vatname" id="vatname" class="form-control " style="width: 100px" placeholder="" value="<?php echo $row['vatname']; ?>">
										</td>
										<td>
											<input type="number" name="vat" id="vat" class="w3-margin-left form-control " style="width: 80px" placeholder="" value="<?php echo $row['vat']; ?>">
										</td>
									</tr>
								</table>
							</div>
							<div class="col-lg-6">
								<button class="w3-button w3-margin-top w3-red" id="add_Bill" name="add_Bill" type="submit">Update <i class="fa fa-angle-double-right"></i></button>
							</div>
							<?php } 
							mysqli_close($conn);
							?>
						</form>
					</div>			
				</div>


			</div>
			
			<script>
				$(document).ready(function()
				{
					$("#menu_category").change(function()
					{
						var id=$(this).val();
						var dataString = 'id='+ id;

						$.ajax
						({
							type: "POST",
							url: "admin_showMenuItem.php",
							data: dataString,
							cache: false,
							success: function(html)
							{
								$("#menu_item").html(html);
							} 
						});
					});
				});

				function delTable(id){
					$.confirm({
			title: '<label class="w3-xlarge w3-text-red w3-large fa fa-warning"> Delete the Table!</label>',
			
			buttons: {
				confirm: function () {
						var dataS = 'id='+ id;
						$.ajax({
        url:"delTable.php", //the page containing php script
        type: "POST", //request type
        data: dataS,
        cache: false,
        success:function(html){
        	$("#deleteMsg").html(html);
        	setTimeout(function() {
        		window.location.reload();
        	}, 1000);
        }
    });
					},
				cancel: function () {

				}
			}
		});

				}



			</script>
			<script>
				$("#add_menuItem").click( function() {
					$.post( $("#form_addItem").attr("action"), 
						$("#form_addItem :input").serializeArray(), 
						function(info){ 
							$.alert(info);
						location.reload();

						});
					clearInput();
				});

				$("#form_addItem").submit( function() {
					return false;	
				});

				function clearInput() {
					$("#form_addItem :input").each( function() {
						$(this).val('');
					});
				}
			</script>
			<script>
				$('input[name=disable_item]:unchecked').click(function(){
    //if a checkbox with name 'favorite' is clicked, do the following.
    //grab the id from the clicked box
    var item_id=$(this).attr('item_id');
    //grab the value from the checkbox (remember, if it is checked it will be 'on', else ''
    var disable_item=$(this).val();
    //setup the ajax call
    $.ajax({
    	type:'POST',
    	url:'disable_item.php',
    	data:'item_id= '+item_id,
    	cache: false,
    	success:function(msg){
    		alert(msg);

    	}
    });

});
</script>
</body>
</html>