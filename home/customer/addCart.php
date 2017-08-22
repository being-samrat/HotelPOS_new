<?PHP
session_start();

if (isset($_POST['item_id'])) 
{
	$item_name = $_POST['item_name'];
	$item_id = $_POST['item_id'];
	$item_quantity = $_POST['item_quantity'];
	$item_price = $_POST['item_price'];

	$cart_array=json_decode($_SESSION['cart'],true);

	foreach ($cart_array as $key => $value) {
		if (in_array($item_id, $value)) {			
			$item_quantity += $cart_array[$key]['quantity'];// +=$item_quantity;
			
			unset($cart_array[$key]);
			}			
		}

		$cart_items=array(
		'item_id'=>$item_id,
		'item_name' => $item_name,
		'quantity' => $item_quantity,
		"item_price" => $item_price
		);
	$cart_array[]=$cart_items;
	$_SESSION['cart']=json_encode($cart_array);
		
	//array_merge($_SESSION['cart'],$new_item);
	//echo sizeof($_SESSION['cart']);
}

if (isset($_POST['delete_item_id'])) 
{
	$del_id=$_POST['delete_item_id'];
	$cart_array= json_decode($_SESSION['cart'] , true); // $cars is the json array before decoding
	foreach ($cart_array as $key => $value) {
		if (in_array($del_id, $value)) {
			unset($cart_array[$key]);
		}
	}
	$_SESSION['cart']= json_encode($cart_array);
}
?>
