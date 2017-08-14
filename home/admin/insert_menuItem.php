<?php 
// if(isset($_REQUEST))
// {

error_reporting(E_ERROR | E_PARSE);
include_once("../db_conn/conn.php");

$new_itemName=$_POST['new_itemName'];
$new_itemPrice=$_POST['new_itemPrice'];
$cat_id=$_POST['cat_id'];
$check = $_POST['menuAC'];

if($new_itemName=='' || $new_itemPrice=='' || $cat_id=='Select Category'){
	echo "<script>alert('Check every Fields');</script>";
}
else{
	if($check=='1'){
		$new_itemName=$new_itemName." (A/c)";
	}

	$newcat_sql="INSERT INTO menu_items(item_name,item_price,cat_id,status) VALUES ('".$new_itemName."','".$new_itemPrice."','".$cat_id."','".$check."')";


	if ((mysqli_query($conn,$newcat_sql)==TRUE)) {

		echo "".$new_itemName." Menu added";
	}
	else{
		echo "Insertion Failed"; 
	}
}

mysqli_close($conn);


?>