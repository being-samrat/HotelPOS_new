<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php")
?>
<?php
session_start();

?>
<!--  -->
<div class="w3-main ">
	<!-- Header -->
	<header class="w3-container">
		<h5><a href="customer_home.php"><b><i class="fa fa-arrow-left"></i> Back to Menu Items</b></a></h5>
	</header>

	<div class="col-sm-12">

		<div class="row">
			<div class="w3-col l12 s12">
				<div class="well w3-margin-left w3-margin-right">
					<div class="w3-center w3-xxlarge">
						<?php ;
						$table_ID=$_SESSION['customer_table'];
						$get_tno="SELECT * FROM hotel_tables WHERE table_id='".$table_ID."'";
						$get_tno_res=mysqli_query($conn,$get_tno);
						$table_NO="";
						while($row = mysqli_fetch_array( $get_tno_res))
						{ 
      						$table_NO=$row['table_name']; //get table name from table_id.............................
      					}
						echo "Table No: T".$table_NO." ";

      					?>
      					<hr>
      				</div>
      				<table class="table table-responsive" style="overflow-x: scroll;overflow: hidden">
      					<thead>
      						<tr>
      							<th class="text-center">Item Name</th>
      							<th class="text-center">Quantity</th>
      							<th class="text-center">Price (each)</th>
      							<th class="text-center">Net Price</th>
      						</tr>
      					</thead>
      					<tbody>
      						<?php 
      						$fetch_orders="SELECT * FROM order_table WHERE table_id='$table_ID' AND order_open='1'";
      						$fetch_orders_result=mysqli_query($conn,$fetch_orders);
      						$items="";
      						$item_rate="";
      						$item_id="";


      						while($row=mysqli_fetch_assoc($fetch_orders_result))
      						{
      							$items= $row['ordered_items'];
      						}
      						$json=json_decode($items,true);
      						$total_amt=0;
      						foreach ($json as $row) {
      							$total=$row['item_price'] * $row['quantity'];
      							echo '
      							<tr>
      								<td class="text-center">'.$row['item_name'].'</td>
      								<td class="text-center">'.$row['quantity'].'</td>
      								<td class="text-center">'.$row['item_price'].' <i class="fa fa-inr"></i></td>
      								<td class="text-center">'.$total.' <i class="fa fa-inr"></i></td>

      							</tr>';
									//echo $row['item_name']." ";
      							$total_amt += $total;
      						}
      						echo '<tr class="w3-border-top">
      						<td></td>
      						<td></td>
      						<td class="text-center" style="font-weight:bold">TOTAL AMT.</td>
      						<td class="text-center" style="font-weight:bold">'.$total_amt.' <i class="fa fa-inr"></i></td>
      					</tr>'

      					?>


      				</tbody>
      			</table>

      		</div>
      	</div>

      </div>
  </div>

</div>


</body>
</html>