<?PHP
	session_start();
	
	if (isset($_GET['item_id'])) 
	{
		$item_name = $_GET['item_name'];
		
		array_push($_SESSION['cart'], $item_name);
		header("Location: demo.php");
	}
?>
