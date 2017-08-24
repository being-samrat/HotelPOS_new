<?php
header('Content-Type: application/json');

error_reporting(E_ERROR | E_PARSE);

include_once("../../db_conn/conn.php");
?>
<?php
$from = $_GET['from'];
$to  = $_GET['to'];
$item =  $_GET['menuitem'];

$date1=date_create($from);
$date2=date_create($to );
$diff=date_diff($date1,$date2);
$between_dates=$diff->format("%a");
$between_dates += 1;


$count = "0";
$items_array = array();

for($i=0;$i<$between_dates;$i++){

	$sql1 = "SELECT * FROM order_table WHERE  date_time = '$from'";
	$result1 = mysqli_query($conn,$sql1);
	while($row1 = mysqli_fetch_array($result1)){
               // echo $row1['date_time'];
		
		$ordered_items  = $row1['ordered_items'];
		$order_array=json_decode($ordered_items,true);

		foreach($order_array as $k)
		{  
			if($k['item_name'] == $item)
			{
				$count = $count + $k['quantity'];

			} 
		}
	}
        //echo $from;
        //echo "-".$count;     //   die();
	$items_array[] = array(
		'date'=>$from,
		'count'=>$count
		);
	$count = "0";

	$dateincrement = strtotime("+1 day", strtotime($from));
	$from = date("Y-m-d", $dateincrement);    
	if($from > $to){
		break;
	}

}

print json_encode($items_array);
?>