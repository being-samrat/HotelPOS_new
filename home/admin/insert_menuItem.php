<?php 

error_reporting(E_ERROR | E_PARSE);
include_once("../db_conn/conn.php");

extract($_POST);
$image="../images/Menu_images/default_menu.png";

if($new_itemName=='' || $new_itemPrice=='' || $cat_id=='Select Category'){
	echo 'Check every Fields';	
}
else{

	$sql="SELECT * FROM menu_items WHERE LOWER(item_name)=LOWER('".$new_itemName."') AND visible=1 ";
	$result=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($result);

	if ($count > 0) {
		echo 'Menu Item already exist!!! Try different';
		//die();
	}

else{
	if($menuAC=='1'){
		$new_itemName=$new_itemName." (A/c)";
	}
	$newcat_sql="INSERT INTO menu_items(item_image,item_name,item_price,cat_id,status) VALUES ('".$image."','".$new_itemName."','".$new_itemPrice."','".$cat_id."','".$menuAC."')";


	if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
		echo $new_itemName." Added Successfully"; 
	}
	else{
		echo "Insertion Failed"; 
	}
}

mysqli_close($conn);	
}


?>