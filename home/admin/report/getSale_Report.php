<?php
header('Content-Type: application/json');

error_reporting(E_ERROR | E_PARSE);

include_once("../../db_conn/conn.php");
?>
<?php
$from = $_GET['from'];
$to  = $_GET['to'];

$date1=date_create($from);
$date2=date_create($to );
$diff=date_diff($date1,$date2);
$between_dates=$diff->format("%a");
$between_dates += 1;

$today=date("Y-m-d");

$totalSale = "0";
$sale_name = array();

for($i=0;$i<$between_dates;$i++){

	$TotalOrderSale_sql="SELECT sum(revenue) FROM order_bill WHERE dated='".$from."'" ;

  $TotalSale=mysqli_query($conn,$TotalOrderSale_sql);//-------------------get total sum of todays sold orders
  
  while($row=mysqli_fetch_array($TotalSale))
  {
  	if(($row['sum(revenue)'])==NULL){
  		$totalSale=0;

  	}
  	else{
  		$totalSale=$row['sum(revenue)'];
  	}
  }
  
  
	        //echo $from;
        //echo "-".$count;     //   die();
  $sale_name[] = array(
  	'date'=>$from,
  	'count'=>$totalSale
  	);

  $dateincrement = strtotime("+1 day", strtotime($from));
  $from = date("Y-m-d", $dateincrement);    
  if($from > $to){
  	break;
  }

}

print json_encode($sale_name);
?>