<?php 
// if(isset($_REQUEST))
// {
include_once("../../db_conn/conn.php");

if (!isset($_POST['food_quantity'])) {
	echo "Enter quantity";
}
else{
	$item_name=$_POST['search_food'];
	$item_quantity=$_POST['food_quantity'];
	$parcel_id=$_POST['parcel_id'];
	$item_id="";
	$item_price="";

	$item_sql="SELECT * FROM menu_items WHERE item_name='$item_name'";
	$item_sql_result=mysqli_query($conn,$item_sql);
	while($row = mysqli_fetch_array( $item_sql_result))
	{
		$item_id=$row['item_id'];
		$item_price=$row['item_price'];

}//
//-------------------------------------------
$kot_id="";
$kot_items="";
$kot_price="";
$kot_sql="SELECT * FROM kot_table WHERE parcel_id='$parcel_id' AND print_status='1'";
$kot_sql_result=mysqli_query($conn,$kot_sql);
while($row = mysqli_fetch_array( $kot_sql_result))
{
	$kot_id=$row['kot_id'];
	$kot_items=$row['kot_items'];
	$kot_price=$item_price;

}

$kot_array=json_decode($kot_items,true);
$extra=array(
	'item_id'=>$item_id,
	'item_name' => $item_name,
	'quantity' => $item_quantity
	);
$kot_array[]=$extra;
$new_item=json_encode($kot_array);

$ukot_sql="UPDATE kot_table SET kot_items='$new_item' WHERE kot_id='$kot_id' AND print_status='1' ";
$result=mysqli_query($conn,$ukot_sql);



//------------insert value in order table-------------------
$order_id="";
$ordered_items="";
$total_kot="";
$order_sql="SELECT * FROM order_table WHERE parcel_id='$parcel_id' AND order_open='1'";
$order_sql_result=mysqli_query($conn,$order_sql);
while($row = mysqli_fetch_array( $order_sql_result))
{
	$order_id=$row['order_id'];
	$ordered_items=$row['ordered_items'];
	$total_kot=$row['total_kot'];

}

$order_array=json_decode($ordered_items,true);
$orderKOT_array=json_decode($total_kot,true);

$extraOI=array(
	'item_id'=>$item_id,
	'item_name' => $item_name,
	'quantity' => $item_quantity,
	'item_price' => $item_price
	);
$extraOKOT=array(
	'kot_id'=>$kot_id
	);

$order_array[]=$extraOI;
$orderKOT_array[]=$extraOKOT;

$new_item_order=json_encode($order_array);
$new_kot_order=json_encode($orderKOT_array);

$uOrder_sql="UPDATE order_table SET total_kot='$new_kot_order',ordered_items='$new_item_order' WHERE order_id='$order_id'";
$Order_result=mysqli_query($conn,$uOrder_sql);


//------------------end-----------------------------------------





//-----------------------------------------------------
if($result){
	echo '<div class="alert alert-danger w3-margin-bottom">
	<strong>Added '.$item_name.'!</strong> 
	</div>
	<script>
		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 900);
	</script>';
}
else{
	echo "Insertion Failed"; 
}
}
mysqli_close($conn);


?>