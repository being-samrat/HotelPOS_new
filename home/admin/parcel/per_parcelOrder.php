<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../../db_conn/conn.php");
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

$parcel_id= $_GET['parcel_id'];
$parcelBy=$_GET['parcelBy']; 
//session_start();
$fetch_kot="SELECT * FROM kot_table WHERE parcel_id='$parcel_id'";
$fetch_kot_result=mysqli_query($conn,$fetch_kot);
$kot_open="disabled";	

while($row=mysqli_fetch_assoc($fetch_kot_result))
{
	if(($row['print_status'])==1){
		$kot_open="";

	}
}

?>
<header class="w3-container ">
	<h5><b><i class="fa fa-user"></i> Action</b></h5>			
</header>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-12">
			<div class="well" >
				<div class="w3-center w3-xlarge">
					<?php 
					if($_GET['parcel_id'] && $_GET['parcelBy'])
						{	echo "Order for: P".$parcel_id." ";

					?>
					<hr>
				</div>
				<table class="table" w3-center>
					<thead >
						<tr>
							<th class="w3-center">Item Name</th>
							<th class="w3-center">Quantity</th>
							<th class="w3-center">Rate</th>
							<th class="w3-center">Net Price</th>

						</tr>
					</thead>
					<tbody class="w3-center">
						<?php 
						$fetch_orders="SELECT * FROM order_table WHERE parcel_id='$parcel_id'";
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
							$total=$row['item_price'] * $row['quantity'];
							echo '
							<tr>
								<td>'.$row['item_name'].'</td>
								<td>'.$row['quantity'].'</td>
								<td>'.$row['item_price'].' Rs</td>
								<td>'.$total.' /-</td>

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
		<button type="button" class=" btn w3-round w3-text-red w3-left w3-border" data-toggle="modal" data-target="#takeOrder"><span class="fa fa-plus"></span> Take Order</button>
		<a class=" btn w3-round w3-text-red w3-right w3-margin-left w3-border" href="parcelOrder_bill.php?parcel_id=<?php echo $parcel_id; ?>&parcelBy=<?php echo $parcelBy; ?>" target="_blank"><span class="fa fa-print"></span> Print BILL</a>
		<a class=" btn w3-round w3-text-red w3-right w3-border" href="parcelKOT_bill.php?parcel_id=<?php echo $parcel_id; ?>&parcelBy=<?php echo $parcelBy; ?>"  target="_blank" <?php echo $kot_open; ?>><span class="fa fa-sticky-note"></span> Print KOT</a>

		<!-- Modal -->
		<div id="takeOrder" class="modal fade " role="dialog">
			<div class="modal-dialog ">
				<!-- Modal content-->
				<div class="modal-content col-lg-8 col-lg-offset-2">
					<div class="modal-header">
						<label>KOT for Parcel </label>
						<input type="hidden" name="parcel_id_ip" id="parcel_id_ip" value="<?php echo $_GET['parcel_id']; ?>" >
						<button type="button" id="mod_close" class="close" data-dismiss="modal">&times;</button>

					</div>
					<div class="modal-body">
						<button id="createKOT_btn" type="button" class="form-control w3-button w3-round w3-red"><span class="fa fa-plus"></span> Start taking Order</button>

						<form id="form_addOrder" action="parcel/parcel_order.php" method="POST" style="display: none">

							Parcel No :<input type="text" name="parcel_id" id="parcel_id" class="form-control w3-margin-bottom" value="<?php echo $parcel_id; ?>" style="width: 80px;" readonly>

							<input type="text" name="search_food" autocomplete="off" id="search_food" class="form-control w3-margin-bottom" placeholder="Type Item Name" required/>
							<div id="search_foodList" class="w3-card-2">

							</div>

							<input type="number" name="food_quantity" id="food_quantity" class="form-control w3-left " style="width: 80px" placeholder="Count" required/>

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

        var parcelID = $('#parcel_id_ip').val(); //where #table could be an input with the name of the table you want to truncate

        $.ajax({
        	type: "POST",
        	url: "parcel/parcelKOT.php",
        	data: 'parcel_id='+ parcelID,
        	cache: false,
        	success: function(response) {
        		$('#KOT_add').html(response);  
        		document.getElementById('form_addOrder').style.display='block';
        		document.getElementById('createKOT_btn').style.display='none';
        	},
        	error: function(xhr, textStatus, errorThrown) {
        		alert('request failed');
        	}
        });

    });
	});
</script>
<script>  
	$(document).ready(function(){  
		$('#search_food').keyup(function(){  
			var query = $(this).val();  
			if(query != '')  
			{  
				$.ajax({  
					url:"parcel/search_food.php",  
					method:"POST",  
					cache:false,
					data:{query:query},  
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

<script>
	$('#takeOrder').on('hidden.bs.modal', function () {
//location.reload();
$("#per_parcelOrder").load("parcel/per_parcelOrder.php?parcel_id=<?php echo $parcel_id; ?>&parcelBy=<?php echo $parcelBy; ?>");
     //$('#view_div').load('view_tab.php');


 })
</script>
