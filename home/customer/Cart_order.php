<?php 
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php");
session_start();
if (!isset($_SESSION['cart'])) {
	echo 'Basket is empty!';
}

else{
	$table_id=$_POST['table_id'];
	$item_id="";
	$item_price="";
	$item_count="";

//-------------------------------------------
	$kot_id="";
	$kot_items="";
	$kot_price="";
	$kot_sql="SELECT * FROM kot_table WHERE table_id='$table_id' AND print_status='1'";
	$kot_sql_result=mysqli_query($conn,$kot_sql);
	while($row = mysqli_fetch_array( $kot_sql_result))
	{
		$kot_id=$row['kot_id'];
		$kot_items=$row['kot_items'];
	}

	$kot_array=json_decode($kot_items,true);
	$kot_cart=json_decode($_SESSION['cart'],true); 

	foreach($kot_cart as $kot){
		$extraCart=array(
			'item_id'=>$kot['item_id'],
			'item_name'=>$kot['item_name'],
			'quantity'=>$kot['quantity'],

			);
		$kot_array[]=$extraCart;
	}
	$new_item=json_encode($kot_array);
	echo $new_item;
	//die();
	$ukot_sql="UPDATE kot_table SET kot_items='$new_item' WHERE kot_id='$kot_id' AND print_status='1' ";
	$result=mysqli_query($conn,$ukot_sql);

//------------insert value in order table-------------------
	$order_id="";
	$ordered_items="";
	$total_kot="";
	$order_sql="SELECT * FROM order_table WHERE table_id='$table_id' AND order_open='1'";
	$order_sql_result=mysqli_query($conn,$order_sql);
	while($row = mysqli_fetch_array( $order_sql_result))
	{
		$order_id=$row['order_id'];
		$ordered_items=$row['ordered_items'];
		$total_kot=$row['total_kot'];

	}

	$order_array=json_decode($ordered_items,true);
	$orderKOT_array=json_decode($total_kot,true);

	$order_cart=json_decode($_SESSION['cart'],true);
	foreach($order_cart as $order){
		$extraOrderCart=array(
			'item_id'=>$order['item_id'],
			'item_name'=>$order['item_name'],
			'quantity'=>$order['quantity'],
			'item_price'=>$order['item_price'],

			);
		$order_array[]=$extraOrderCart;
	}
	$extraOKOT=array(
		'kot_id'=>$kot_id
		);
	$orderKOT_array[]=$extraOKOT;

	$new_item_order=json_encode($order_array);
	$new_kot_order=json_encode($orderKOT_array);

	$uOrder_sql="UPDATE order_table SET total_kot='$new_kot_order',ordered_items='$new_item_order' WHERE order_id='$order_id'";
	$Order_result=mysqli_query($conn,$uOrder_sql);


//------------------end-----------------------------------------

//-----------------------------------------------------
	if($result){
		$cart_array=json_decode($_SESSION['cart'],true);
		foreach ($cart_array as $key => $value) {	

			$item_quantity = $cart_array[$key]['quantity'];// +=$item_quantity;
			$item_id = $cart_array[$key]['item_id'];// +=$item_quantity;
			$count_item_name = $cart_array[$key]['item_name'];

			$item_sql="SELECT * FROM menu_items WHERE item_name='$count_item_name'";
			$item_sql_result=mysqli_query($conn,$item_sql);
			while($row = mysqli_fetch_array( $item_sql_result))
			{
				$item_count=$row['ordered_count'];
			}
			$item_count += $item_quantity;
			$incrementCount_sql="UPDATE menu_items SET ordered_count='$item_count' WHERE item_id='$item_id'";
			$incrementCount_result=mysqli_query($conn,$incrementCount_sql);		

		}

		unset($_SESSION['cart']);
		echo 'Added ';


	}
	else{
		echo "Insertion Failed"; 
	}
}
mysqli_close($conn);


?>