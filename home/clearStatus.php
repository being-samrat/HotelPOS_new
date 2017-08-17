<?php 
error_reporting(E_ERROR | E_PARSE);

include_once("db_conn/conn.php");
$table_id=$_POST['id'];
$table_no=$_POST['no'];

$get_tno="SELECT * FROM hotel_tables,join_table WHERE hotel_tables.join_id=join_table.join_id AND hotel_tables.table_id='$table_id'";
$get_tno_res=mysqli_query($conn,$get_tno);

$table_name="";
$join_tabs="";
$json_join="";
while($row = mysqli_fetch_array( $get_tno_res))
{ 
	$join_tabs=$row['joint_tables'];
	$table_name=$row['table_name'];
}
$json_join=json_decode($join_tabs,true);

$upsql="UPDATE hotel_tables SET occupied='0',kot_open='0' WHERE table_id='$table_id'";
$upsql2="UPDATE order_table SET order_open='0' WHERE table_id='$table_id'";
$upsql3="UPDATE hotel_tables SET join_id='-1' WHERE table_id='$table_id'";

mysqli_query($conn,$upsql);
mysqli_query($conn,$upsql2);
mysqli_query($conn,$upsql3);

foreach($json_join as $k){
	$upsql5="UPDATE hotel_tables SET join_id='-1',occupied='0' WHERE table_id='$k'";
  //$upsql6="UPDATE hotel_tables SET occupied='0' WHERE table_id='$k'";
	mysqli_query($conn,$upsql5);
  //mysqli_query($conn,$upsql6);
	$upsql_join="UPDATE order_bill SET readyTo_print='0' WHERE table_id='$k'";
	mysqli_query($conn,$upsql_join);
}

$upsql4="UPDATE order_bill SET readyTo_print='0' WHERE table_id='$table_id'";
mysqli_query($conn,$upsql4);

echo '<label class="w3-label w3-large">Table '.$table_no.' order is now cleared!!!</label>';

?>
