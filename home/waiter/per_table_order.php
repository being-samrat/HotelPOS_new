<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php");
?>

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
<?php  

$table_id= $_GET['table_id'];
$table_no=$_GET['table_no']; 
session_start();

//$_SESSION['tid']=$table_id;

?>
<?php 
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

?>
<div class="col-sm-12 w3-margin-bottom">
	<div class="row">
		<div class="col-sm-12">
			<div class="well">				

				<div class="w3-center w3-xlarge">
					<?php 
					if($_GET['table_id'] && $_GET['table_no'])
					{
						
						echo "Order for: T".$table_no." ";
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
					<table class="table">
						<thead >
							<tr>
								<th class="w3-center">Item Name</th>
								<th class="w3-center">Quantity</th>
								
							</tr>
						</thead>
						<tbody class="w3-center">
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
								echo '
								<tr>
									<td>'.$row['item_name'].'</td>
									<td>'.$row['quantity'].'</td>
									
								</tr>';
									//echo $row['item_name']." ";

							}


							?>

							
						</tbody>
					</table>
					
				</div>
			</div>

		</div>
	</div>

	<div class="w3-row-padding w3-margin-bottom">
		<div class="w3-col l12 w3-col s12 ">
			<button type="button" class=" btn w3-round w3-text-red w3-left" data-toggle="modal" data-target="#takeOrder"><span class="fa fa-plus"></span> Take Order</button>

			<button type="button" class=" btn w3-round w3-text-red w3-right" data-toggle="modal" data-target="#shiftTable"><span class="fa fa-reply"></span> Shift Table</button>

			
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

			<!-- Modal -->
			<div id="takeOrder" class="modal fade " role="dialog">
				<div class="modal-dialog ">
					<!-- Modal content-->
					<div class="modal-content col-lg-8 col-lg-offset-2">
						<div class="modal-header">
							<label>KOT for TNO: <?php echo $_GET['table_no']; ?></label>
							<input type="hidden" name="table_id_ip" id="table_id_ip" value="<?php echo $_GET['table_id']; ?>" ><input type="hidden" name="table_no_ip" id="table_no_ip" value="<?php echo $_GET['table_no']; ?>" >
							<button type="button" id="mod_close" class="close" data-dismiss="modal">&times;</button>

						</div>
						<div class="modal-body">
							<button id="createKOT_btn" type="button" class="form-control w3-button w3-round w3-red"><span class="fa fa-pencil"></span> Start taking Order</button>
							
							<form id="form_addOrder" action="insert_order.php" method="POST" style="display: none">

								<input type="hidden" name="table_id" id="table_id" class="form-control w3-margin-bottom" value="<?php echo $_GET['table_id']; ?>" style="width: 80px;" readonly>
								
								<input type="text" name="search_food" autocomplete="off" id="search_food" class="form-control w3-margin-bottom" placeholder="Type Item Name">
								<div id="search_foodList" class="w3-card-2">
									
								</div>

								<input type="number" name="food_quantity" id="food_quantity" class="form-control w3-left " style="width: 80px" placeholder="Count">

								<button class="btn w3-red w3-margin-left" id="add_orderItem" name="add_orderItem" type="submit">Add <i class="fa fa-angle-double-right"></i>
								</button>
							</form>	
							<div id="KOT_add" class="w3-margin-top"></div>
						</div>
					</div>
				</div>
			</div>
			<!--modal end-->


		</div>
	</div>
	<?php } ?>
	<script>
		$(document).ready(function() {

			$('#createKOT_btn').click(function() {

        var tableID = $('#table_id_ip').val(); //where #table could be an input with the name of the table you want to truncate
        var tableNO = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate

        $.ajax({
        	type: "POST",
        	url: "createKOT.php",
        	data: 'table_id='+ tableID +'&table_no='+ tableNO,
        	cache: false,
        	success: function(response) {

        		document.getElementById('form_addOrder').style.display='block';
        		document.getElementById('createKOT_btn').style.display='none';
        	},
        	error: function(xhr, textStatus, errorThrown) {
        		$.alert('request failed');
        	}
        });

    });
		});
	</script>
<!-- 	<script>
		$(document).ready(function() {

			$('#customer_page').click(function() {

        var tableID = $('#table_id_ip').val(); //where #table could be an input with the name of the table you want to truncate
        var tableNO = $('#table_no_ip').val(); //where #table could be an input with the name of the table you want to truncate

        $.ajax({
        	type: "POST",
        	url: "customer/customer.php",
        	data: 'table_id='+ tableID +'&table_no='+ tableNO,
        	cache: false,
        	success: function(response) {

        		
        	},
        	error: function(xhr, textStatus, errorThrown) {
        		$.alert('request failed');
        	}
        });

    });
		});
	</script> -->

<!-- 	Script to autocomplete search food items ....................
-->	
<script>  
	$(document).ready(function(){  
		$('#search_food').keyup(function(){  
			var query = $(this).val();  
			var table_id = $('#table_id').val();  
			var data = {
				table_id:table_id,
				query:query
			};
			if(query != '')  
			{  
				$.ajax({  
					url:"search_food.php",  
					method:"POST",  
					cache:false,
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
			$('#search_food').val($(this).text());  
			$('#search_foodList').fadeOut();  
		});  
	}); 

</script> 


<!-- 	Script to add items in kot tabke and order table..........................
-->	
<script>
	$("#add_orderItem").click( function() {
		$.post( $("#form_addOrder").attr("action"), 
			$("#form_addOrder :input").serializeArray(), 
			function(info){ 
				$("#KOT_add").html(info);

			});
		clearInput();
	});

	$("#form_addOrder").submit( function() {
		return false;	
	});

	function clearInput() {
		$("#form_addOrder :input").each( function() {
			$('#food_quantity').val('');
			$('#search_food').val('');
		});
	}
</script>

<!-- 	Script to reload order page when take order modal closes............................
-->	
<script>
	$('#takeOrder').on('hidden.bs.modal', function () {
//location.reload();
$("#per_table_order").load("per_table_order.php?table_id=<?php echo $table_id; ?>&table_no=<?php echo $table_no; ?>");
     //$('#view_div').load('view_tab.php');
 })
</script>

