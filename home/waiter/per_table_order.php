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
.todolist{
	background-color:#FFF;
	padding:20px 20px 10px 20px;
	margin-top:30px;
}

#done-items li{
	padding:5px;
	border-bottom:1px solid #ddd;
	font-size: 14px;
}
#done-items li:last-child{
	border-bottom:none;
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
			<div class="w3-col l12 well" style="margin-bottom: -2px">				

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
					<table class="table table-responsive w3-center">
						<thead >
							<tr>
								<th class="w3-center" style="min-width: 120px">Item Name</th>
								<th class="w3-center">Quantity</th>
								<th class="w3-center">#</th>

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
							$count=0;
							$json=json_decode($items,true);
							foreach ($json as $row) {
								$count++;
								$item=array($row['item_id'],$row['quantity']) ;
								$item= implode('|', $item);
								echo '
								<tr>
								<td>'.$row['item_name'].'</td>
								<td>'.$row['quantity'].'</td>
								<td>
								<button type="button" class=" btn w3-medium fa fa-sticky-note-o" style="padding:0" title="Add Note" onclick="addNote_item(\''.$item.'\')" ></button>
								<button type="button" class=" btn w3-medium fa fa-edit" style="padding:0" title="Edit Quantity" onclick="editOrder_item(\''.$item.'\')" ></button>
								<button type="button" class=" btn w3-medium fa fa-remove" style="padding:0" title="Delete Item" onclick="delOrder_item(\''.$item.'\')" ></button>
								</td>

								</tr>';

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
					
				</div>
				
				<?php
				$kot_status="SELECT * FROM kot_table WHERE table_id='$table_id' AND print_status='1'";
				$kot_status_result=mysqli_query($conn,$kot_status);

				$kot_id="";
				while($row = mysqli_fetch_array( $kot_status_result))
				{

					$kot_id=$row['kot_id'];

				}

				$fetch_print="SELECT * FROM hotel_tables WHERE table_id='$table_id'";
				$fetch_print_result=mysqli_query($conn,$fetch_print);

				while($row = mysqli_fetch_array( $fetch_print_result))
				{
					$print_kot="";
					$print_bill="";
					
					if (($row['occupied']==1)) {

						$print_bill="";
					}else{
						$print_bill="disabled";
					}

					if (($row['kot_open']==1)) {
							
						$print_kot="";
					}else{
						$print_kot="disabled";
					}
				}
				?>
				<div class="w3-col l12 w3-right w3-small" id="print_waiter">
					<a class="btn w3-border-bottom w3-border-left w3-small w3-border-right w3-light-red w3-button w3-text-red" target="_blank" href="../admin/bill_of_kot.php?kot_id=<?php echo $kot_id; ?>&table_no=<?php echo $table_no; ?>&table_id=<?php echo $table_id; ?>" style="margin-top:0;margin-left:20px;padding:5px" <?php echo $print_kot ?> onclick="location.reload();"><span class="fa fa-sticky-note"> KOT</span></a>

					<a class="btn w3-border-bottom w3-border-left w3-small w3-border-right w3-button w3-light-red w3-text-red" target="_blank" href="../admin/bill_of_table.php?table_id=<?php echo $table_id; ?>&table_no=<?php echo $table_no; ?>" style="margin-top:0;padding:5px" <?php echo $print_bill ?> onclick="location.reload();"><span class="fa fa-print"> Bill</span></a>
				</div>
			</div>
			
		</div>
	</div>

	<div class="w3-row-padding w3-margin-bottom">
		<div class="w3-col l12 w3-col s12 w3-margin-top">
			<button type="button" class=" btn w3-round w3-text-red w3-left" data-toggle="modal" data-target="#takeOrder" id="takeObtn"><span class="fa fa-plus"></span> Take Order</button>

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
							<button id="createKOT_btn" type="button" class="form-control w3-button w3-round w3-red "><span class="fa fa-pencil"></span> Start taking Order</button>
							
							<form id="form_addOrder" action="insert_order.php" method="POST" style="display: none">

								<input type="hidden" name="table_id" id="table_id" class="form-control w3-margin-bottom" value="<?php echo $_GET['table_id']; ?>" style="width: 80px;" readonly>
								
								<input type="text" name="search_food" autocomplete="off" id="search_food" class="form-control w3-margin-bottom" placeholder="Type Item Name">
								<div id="search_foodList" class="w3-card-2"></div>

								<input type="number" name="food_quantity" id="food_quantity" class="form-control w3-left w3-margin-bottom" style="width: 80px" placeholder="Count">														
								
								<br>
								<br>
								<hr>										
								<a class="w3-small btn fa fa-sticky-note w3-text-red" data-toggle="collapse" data-parent="#accordion" href="#add_note" style="padding:0"><i>&nbsp;Add Note (optional)</i></a>
								<br>											
								<div id="add_note" class="collapse well">										
									<i><label class="w3-small w3-text-grey">Special Requirement :</label></i>
									<i><textarea class="form-control w3-margin-bottom" id="item_note" name="item_note" cols="4" placeholder="Ex.Spicy, Sugar-free, Egg-less, etc. "></textarea></i>
								</div>																
								<button class="btn w3-red w3-right " id="add_orderItem" name="add_orderItem" type="submit">Add <i class="fa fa-angle-double-right"></i>
								</button>										

							</form>	
							<br>
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
		//location.reload();		
	});

	$("#form_addOrder").submit( function() {
		return false;	
	});

	function clearInput() {
		$("#form_addOrder :input").each( function() {
			$('#food_quantity').val('');
			$('#search_food').val('');
			$('#item_note').val('');
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
     
 });
</script>

<!-- 	Script to delete item from order list............................
-->	
<script type="text/javascript">
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
  				url:'delOrder_item.php',
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
    				url:'editOrder.php',
    				data:{
    					item_id:item_id,
    					item_quantity:quantity,
    					table_id:table_id,
    					new_qty:new_qty,
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
    					url:'addNote.php',
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