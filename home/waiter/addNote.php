<?php 
include_once("../db_conn/conn.php");

$item_id=$_POST['item_id'];
$item_quantity=$_POST['item_quantity'];
$table_id=$_POST['table_id'];
$table_no=$_POST['table_no'];
$new_note=$_POST['new_note'];
$item_name="";
$item_price="";
$item_count="";
$date=date("Y-m-d");
  // print_r($_POST);
 // die();

//....................get item data.............................
$getitem_sql="SELECT * FROM menu_items WHERE item_id='$item_id'";
$getitem_result=mysqli_query($conn,$getitem_sql);

while($row = mysqli_fetch_array( $getitem_result))
{
	$item_name=$row['item_name'];
}
//..............................................................


//.......................remove item from item json in kot table.............................
$kot_id="";
$kot_items="";
$kot_sql="SELECT * FROM kot_table WHERE table_id='$table_id' AND print_status='1'";
$kot_sql_result=mysqli_query($conn,$kot_sql);

//......................edit json array if kot not printed .................................
if((mysqli_num_rows($kot_sql_result)) > 0) {

	while($row = mysqli_fetch_array( $kot_sql_result))
	{
		$kot_id=$row['kot_id'];
		$kot_items=$row['kot_items'];
	$kot_array= json_decode($kot_items, true); // $kot_items is the json array before decoding

	foreach ($kot_array as $key => $value) {		
		if (($kot_array[$key]['item_id']==$item_id) && ($kot_array[$key]['quantity']==$item_quantity) && ($kot_array[$key]['item_note']=='')){	
			$kot_array[$key]['item_note']=$new_note;		
			//unset($kot_array[$key]);
			break;
		}
		else if(($kot_array[$key]['item_id']==$item_id) && ($kot_array[$key]['quantity']==$item_quantity) && ($kot_array[$key]['item_note']!='')){
			$kot_array[$key]['item_note']=$kot_array[$key]['item_note'].','.$new_note;		
			//unset($kot_array[$key]);
			break;
		}		
	}
	
	$new_item= json_encode($kot_array);	
}

$update_kot_sql="UPDATE kot_table SET kot_items='$new_item' WHERE kot_id='$kot_id'";
$update_kot_result=mysqli_query($conn,$update_kot_sql);
//...........................................................................
}
//.............................print edited kot......................................
else{
	
	$kot_array=json_decode($kot_items,true);
	$extra=array(
		'item_id'=>$item_id,
		'item_name' => $item_name,
		'quantity' => 0,
		'item_note' => $new_note
		);
	$kot_array[]=$extra;
	$new_item=json_encode($kot_array);

	$insert_kot_sql="INSERT INTO kot_table(kot_id,table_id,table_no,kot_items,date_time,print_status) VALUES ('','".$table_id."','".$table_no."','".$new_item."','".$date."','1')";
	$insert_kot_result=mysqli_query($conn,$insert_kot_sql);

	if($insert_kot_result){
		$openKOT_sql="UPDATE hotel_tables SET kot_open='1' WHERE table_id='$table_id'";
		$openKOT_result=mysqli_query($conn,$openKOT_sql);

	}
}
//................................................................

?>