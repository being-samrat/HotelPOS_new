<?php 
// if(isset($_REQUEST))
// {

//error_reporting(E_ERROR | E_PARSE);
include_once("../db_conn/conn.php");

extract($_POST);
$image="Menu_images/default_menu.jpg";
$item_code="";

if($new_itemName=='' || $new_itemPrice=='' || $cat_id=='Select Category'){
	echo "<script>alert('Check every Fields ".$image."');</script>";
}

else{
	if($menuAC=='1'){
		$new_itemName=$new_itemName." (A/c)";
	}
	$newcat_sql="INSERT INTO menu_items(item_image,item_name,item_price,cat_id,status) VALUES ('".$image."','".$new_itemName."','".$new_itemPrice."','".$cat_id."','".$menuAC."')";


	if ((mysqli_query($conn,$newcat_sql)==TRUE)) {

	}
	else{
		echo "Insertion Failed"; 
	}
}

mysqli_close($conn);	



?>