<?PHP
	session_start();
	
	if (isset($_GET['item_id'])) 
	{
		$item_name = $_GET['item_name'];
		$item_id = $_GET['item_id'];
		
		array_push($_SESSION['cart'],array("id" => $item_id, "name" => $item_name) );
		header("Location: demo.php");
	}
?>
