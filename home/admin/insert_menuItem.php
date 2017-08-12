<?php 
// if(isset($_REQUEST))
// {
 include_once("../db_conn/conn.php");

$new_itemName=$_POST['new_itemName'];
$new_itemPrice=$_POST['new_itemPrice'];
$cat_id=$_POST['cat_id'];
$item_id="0";


$sql="INSERT INTO menu_items(item_name,item_price,cat_id) VALUES ('".$new_itemName."','".$new_itemPrice."','".$cat_id."')";
$result=mysqli_query($conn,$sql);
if($result){
echo "Added ".$new_itemName;

}
else{
		  echo "Insertion Failed"; 
}
mysqli_close($conn);

?>