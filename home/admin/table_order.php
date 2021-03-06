<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php")
?>
<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Table Order</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>
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
	<style>  
		.searchUL{  
			background-color:#E4E4E4;  
			cursor:pointer;  
		}  
		.searchLI{  
			padding:8px;  
		}  
	</style>  
	<style>

		/* Include the padding and border in an element's total width and height */
		* {
			box-sizing: border-box;
		}

		/* Remove margins and padding from the list */
		ul {
			margin: 0;
			padding: 0;
			list-style: none; 
		}

		/* Style the list items */
		ul li {
			cursor: pointer;
			position: relative;

			background: #eee;
			font-size: 18px;
			transition: 0.2s;

			/* make the list items unselectable */
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.unselectable {
			-moz-user-select: -moz-none;
			-khtml-user-select: none;
			-webkit-user-select: none;
			-o-user-select: none;
			user-select: none
		}
		/* Set all odd list items to a different color (zebra-stripes) */
		ul li:nth-child(odd) {
			background: #f9f9f9;
		}

	</style>
</head>
<body>
	<body style="background-color: #E4E4E4">
		<?php 
		if(isset($_SESSION['admin_passwd']))
		{
			include("admin_navigation.php");
		}
		else{
			include("cashier_nav.php");
		}


		?>
		<!--  -->
		<div class="w3-main " style="margin-left:300px;margin-top:43px;">
			<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
			<!-- Header -->
			<header class="w3-container " style="padding-top:22px">
				<h5><b><i class="fa fa-coffee"></i> View Tables</b></h5>
				<input class="form-control " type="hidden" name="table_id" placeholder="" value = "<?php echo $_GET['table_id']; ?>" required/>  
				<input class="form-control " type="hidden" name="table_no_ip" placeholder="" value = "<?php echo $_GET['table_no']; ?>" required/>  

			</header>

			<div class="col-sm-12">

				<div class="row">
					<div class="col-sm-12">
						<div class="well">
							<div class="w3-center w3-xxlarge" >
								<?php ;
								$table_no= $_GET['table_no'];
								$table_id= $_GET['table_id'];
								$_SESSION['tid']=$table_id;
								$get_tno="SELECT * FROM hotel_tables,join_table WHERE hotel_tables.join_id=join_table.join_id AND hotel_tables.table_id='$table_id'";
								$get_tno_res=mysqli_query($conn,$get_tno);

								$ACStatus="";
								$getAcstat="SELECT * FROM hotel_tables WHERE table_id='$table_id'";
								$getAcstat_res=mysqli_query($conn,$getAcstat);
								while($row = mysqli_fetch_array( $getAcstat_res))
								{ 
									$ACStatus=$row['status'];//get Table Ac or nonAc.........................
								}

								$join_tabs="";
								$json_join="";
								while($row = mysqli_fetch_array( $get_tno_res))
								{ 
									$join_tabs=$row['joint_tables'];
								}
								$json_join=json_decode($join_tabs,true);

								echo "Table No: T".$table_no." ";
								foreach($json_join as $k){
									$join_tno="SELECT * FROM hotel_tables WHERE table_id='$k'";
									$join_tno_res=mysqli_query($conn,$join_tno);

									while($row = mysqli_fetch_array( $join_tno_res))
									{ 
										echo "T".$row['table_name']." ";
									}

								}
								?>
								<hr>
							</div>
							<table class="table table-responsive" style="overflow-x: scroll;overflow: hidden">
								<thead>
									<tr>
										<th>Item Name</th>
										<th>Qty</th>
										<th>Price (each)</th>
										<th>Net Price</th>
										<th>#</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$fetch_orders="SELECT * FROM order_table WHERE table_id='$table_id' AND order_open='1'";
									$fetch_orders_result=mysqli_query($conn,$fetch_orders);
									$items="";
									$item_rate="";
									$item_id="";
									

									while($row=mysqli_fetch_assoc($fetch_orders_result))
									{

										$items= $row['ordered_items'];


									}
									$json=json_decode($items,true);
									
									foreach ($json as $row) {
										$item=array($row['item_id'],$row['quantity']) ;
										$item= implode('|', $item);
										$total=$row['item_price'] * $row['quantity'];
										echo '
										<tr>
											<td>'.$row['item_name'].'</td>
											<td>'.$row['quantity'].'</td>
											<td>'.$row['item_price'].' <i class="fa fa-inr"></i></td>
											<td>'.$total.' <i class="fa fa-inr"></i></td>
											<td>
												<button type="button" class=" btn w3-medium fa fa-sticky-note-o" style="padding:0" title="Add Note" onclick="addNote_item(\''.$item.'\')" ></button>
												<button type="button" class=" btn w3-medium fa fa-edit" style="padding:0" title="Edit Quantity" onclick="editOrder_item(\''.$item.'\')" ></button>
												<button type="button" class=" btn w3-medium fa fa-remove" style="padding:0" title="Delete Item" onclick="delOrder_item(\''.$item.'\')" ></button>
											</td>
											
										</tr>';
									//echo $row['item_name']." ";

									}

									//......................joint tables order.................................
									foreach($json_join as $row){
										$join_table_order_sql="SELECT * FROM order_table WHERE table_id='$row' AND order_open='1'";
										$join_table_order_res=mysqli_query($conn,$join_table_order_sql);

										while($row = mysqli_fetch_array( $join_table_order_res))
										{ 
											$join_items= $row['ordered_items'];
										}
										$join_item_json=json_decode($join_items,true);
										foreach ($join_item_json as $j_items) {
											$join_total=$j_items['item_price'] * $j_items['quantity'];
											echo '
											<tr>
												<td>'.$j_items['item_name'].'</td>
												<td>'.$j_items['quantity'].'</td>
												<td>'.$j_items['item_price'].' <i class="fa fa-inr"></i></td>
												<td>'.$join_total.' <i class="fa fa-inr"></i></td>
												
											</tr>';

										}
									}
									
									//.............................................................
									?>


								</tbody>
							</table>
							<div class="w3-row-padding w3-margin-bottom">
								<div class="w3-col l12 w3-col s12 ">
									<button type="button" class=" btn w3-round w3-text-red w3-left w3-padding-small" data-toggle="modal" data-target="#takeOrder"><span class="fa fa-plus"></span> Take Order</button>

									<button type="button" class=" btn w3-round w3-text-red w3-right w3-padding-small" data-toggle="modal" data-target="#shiftTable"><span class="fa fa-reply"></span> Shift Table</button>


									<!-- Modal -->
									<div id="takeOrder" class="modal fade " role="dialog">
										<div class="modal-dialog ">
											<!-- Modal content-->
											<div class="modal-content col-lg-8 col-lg-offset-2">
												<div class="modal-header">
													<label>TNO: <?php echo $_GET['table_no']; ?></label>
													<input type="hidden" name="table_id_ip" id="table_id_ip" value="<?php echo $_GET['table_id']; ?>" ><input type="hidden" name="table_no_ip" id="table_no_ip" value="<?php echo $_GET['table_no']; ?>" >
													<button type="button" id="mod_close" class="close" data-dismiss="modal">&times;</button>

												</div>
												<div class="modal-body">
													<button id="createKOT_btn" type="button" class="form-control w3-button w3-round w3-red"><span class="fa fa-pencil"></span> Start taking Order</button>
													<form id="myform" name = "myform" action="admin_insertOrder.php" method="POST" style="display:none">
														<input type="hidden" name="table_id" id="table_id" class="form-control w3-margin-bottom" value="<?php echo $_GET['table_id']; ?>" style="width: 80px;" readonly>

														<input type="text" name="name" autocomplete="off" id="name" class="form-control w3-margin-bottom" placeholder="Type Item Name">
														<div id="search_foodList" class="w3-card-2">

														</div>

														<input type="text" name="quantity" id="quantity" class="form-control w3-left" style="width: 80px" placeholder="Count">

														<button class="btn w3-red w3-margin-left" id="sub" name="sub" type="submit">Add <i class="fa fa-angle-double-right"></i>
														</button>
													</form>
													<div id="KOT_add" class="w3-margin-top">
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--modal end-->
									<!-- shift table modal Start -->
									<div id="shiftTable" class="modal fade " role="dialog">
										<div class="modal-dialog ">
											<!-- Modal content-->
											<div class="modal-content col-lg-6 col-md-4 col-sm-12 col-lg-offset-3 col-md-offset-3">    
												<div class="modal-header">
													<label>Shift Table</label>
													<button type="button" id="mod_close" class="close" data-dismiss="modal">&times;</button>

												</div>
												<div class="modal-body">
													<form action="shift_table.php" method="POST">
														<label>Shift Table No: </label>
														<input class="form-control " type="hidden" name="previouse_table_id" placeholder="" value = "<?php echo $_GET['table_id']; ?>" required/>  
														<input class="form-control " type="text" placeholder="" value = "<?php echo $_GET['table_no']; ?>" required/>  

														<label>TO </label>
														<select class="form-control w3-col 4 w3-margin-bottom" name="shift_table" style="" id="">
															<option class="w3-red" selected>Select Table</option>
															<?php 								
															$sqlemptyTABLE="SELECT * FROM hotel_tables WHERE occupied = 0 AND status='$ACStatus' AND table_id != '$table_id'";
															$sqlemptyTABLE_RESULT=mysqli_query($conn,$sqlemptyTABLE);

															while($sqlemptyTABLE_RESULT_ROW = mysqli_fetch_array( $sqlemptyTABLE_RESULT))
															{
																echo '<option value="'.$sqlemptyTABLE_RESULT_ROW['table_id'].'">'.$sqlemptyTABLE_RESULT_ROW['table_name'].'</option>';
															}   
															?>  
														</select>
														<input class="form-control w3-red w3-wide" type="submit" name="table_submit" id="table_submit" value="Shift" >           
													</form>
												</div>
											</div>
										</div>
									</div>
									<!--   shift table modal end -->

								</div>




							</div>
						</div>
					</div>

				</div>
				<a href="admin_viewTable.php" class="w3-padding w3-red"><i class="fa fa-angle-double-left w3-large"></i></a>
			</div>

		</div>

		<script>
			$(document).ready(function() {

				$('#createKOT_btn').click(function() {

        var tableID = $('#table_id_ip').val(); //where #table could be an input with the name of the table you want to truncate
        var tableNO = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate

        $.ajax({
        	type: "POST",
        	url: "../waiter/createKOT.php",
        	data: 'table_id='+ tableID +'&table_no='+ tableNO,
        	cache: false,
        	success: function(response) {
        		
        		document.getElementById('myform').style.display='block';
        		document.getElementById('createKOT_btn').style.display='none';
        	},
        	error: function(xhr, textStatus, errorThrown) {
        		$.alert('request failed');
        	}
        });

    });
			});
		</script>
		<script>  
			$(document).ready(function(){  
				$('#name').keyup(function(){  
					var query = $(this).val();  
					var table_id = $('#table_id_ip').val();
					var data = {
						table_id:table_id,
						query:query
					};  
					if(query != '')  
					{  
						$.ajax({  
							url:"../waiter/search_food.php",  
							method:"POST",  

							data:data,  
							success:function(data)  
							{  
								$('#search_foodList').fadeIn();  
								$('#search_foodList').html(data);  
							}  
						});  
					}  
				});  
				$(document).on('click', 'li', function(){  
					$('#name').val($(this).text());  
					$('#search_foodList').fadeOut();  
				});  
			}); 

		</script> 
		<script>
			$("#sub").click( function() {
				$.post( $("#myform").attr("action"), 
					$("#myform ").serializeArray(),	
					function(info){ 
						$("#KOT_add").html(info);				
					});
				clearInput();
			});
			$("#myform").submit( function() {
				return false;	
			});
			function clearInput() {
				$("#myform :input").each( function() {
					$('#name').val('');
					$('#quantity').val('');
				});
			}
		</script>
		<script>

		</script> 		
		<script>
			$('#takeOrder').on('hidden.bs.modal', function () {
				location.reload();
			})
		</script>

		<script type="text/javascript">
			<!-- 	Script to delete item from order list............................
		-->	
		function delOrder_item(id)
		{
			var item_data = id.split('|'); 
			var id=item_data[0];
			var quantity=item_data[1];
			var table_id = $('#table_id').val(); 
    var table_no = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate

  //var price=document.getElementById("price_"+id).value; 
  
  $.confirm({
  	title: 'Delete Menu Item!',
  	content: 'Want to delete Menu from OrderList?<br><br> <span class="w3-small w3-text-red"><b>[NOTE: Please print the KOT for this table before confirm deletion.]</b></span>',
  	buttons: {
  		confirm: function () {
  			$.ajax({
  				type:'post',
  				url:'../waiter/delOrder_item.php',
  				data:{
  					item_id:id,
  					item_quantity:quantity,
  					table_id:table_id,
  					table_no:table_no
  				},
  				success:function(response) {
  					location.reload();
  				}
  			});
  		},
  		cancel: function () {}
  	}
  });
}
</script>

<!-- 	Script to edit quantity of item in order list............................
-->	
<script type="text/javascript">
	function editOrder_item(id)
	{
		
		var item_data = id.split('|'); 
		var item_id=item_data[0];
		var quantity=item_data[1];
		var table_id = $('#table_id').val(); 
    var table_no = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate
    
    
    $.confirm({
    	
    	title: 'Edit Quantity',
    	content: '' +
    	'<form action="" class="formName">' +
    	'<div class="form-group">' +
    	'<input type="number" placeholder="Enter Quantity" class="new_quantity form-control" required />' +
    	'<br><span class="w3-small w3-text-red"><b>[NOTE: Please print the KOT for this table before confirm updation.]</b></span>' +
    	'</div>' +
    	'</form>',
    	buttons: {
    		submit: function () {
    			var new_qty = this.$content.find('.new_quantity').val();
    			$.ajax({
    				type:'post',
    				url:'../waiter/editOrder.php',
    				data:{
    					item_id:item_id,
    					item_quantity:quantity,
    					table_id:table_id,
    					new_qty:new_qty,
    					table_no:table_no
    				},
    				success:function(response) {
    					location.reload();
    					//alert(response);
    				}
    			});
    		},
    		cancel: function () {}
    	}
    });
}
</script>

<!-- 	Script to add note to item in kot list............................
-->	
<script type="text/javascript">
	function addNote_item(id)
	{
		
		var item_data = id.split('|'); 
		var item_id=item_data[0];
		var quantity=item_data[1];
		var table_id = $('#table_id').val(); 
    	var table_no = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate
    
    
    $.confirm({
    	
    	title: 'Add Note',
    	content: '' +
    	'<form action="" class="formName">' +
    	'<div class="form-group">' +
    	'<label class="w3-label w3-small">Add any special requirement :</label>' +
    	'<textarea class="new_item_note form-control" id="new_item_note" name="new_item_note" cols="4" placeholder="Ex. Spicy, Sugar-free, Egg-less, etc. " required></textarea>' +
    	'<br><span class="w3-small w3-text-red"><b>[NOTE: Please print the KOT for this table before confirm updation.]</b></span>' +
    	'</div>' +
    	'</form>',
    	buttons: {
    		Add: function () {
    			var new_note = this.$content.find('.new_item_note').val();
    			$.ajax({
    				type:'post',
    				url:'../waiter/addNote.php',
    				data:{
    					item_id:item_id,
    					item_quantity:quantity,
    					table_id:table_id,
    					new_note:new_note,
    					table_no:table_no
    				},
    				success:function(response) {
    					location.reload();
    					//alert(response);
    				}
    			});
    		},
    		cancel: function () {}
    	}
    });
}
</script>
</body>
</html>