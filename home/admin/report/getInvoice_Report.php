<?php
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

echo '
<table class="table table-striped table-responsive w3-center" >
<thead class="w3-red">
<tr>
<th>Sr</th>
<th>#Order</th>
<th>#Table No.</th>
<th>#Parcel No.</th>
<th>#Net Revenue</th>
<th>#Dated</th>
<th>#Action</th>
</tr>
</thead>
<tbody class="w3-small ">
';

for($i=0;$i<$between_dates;$i++){

	$TotalOrder_sql="SELECT * FROM order_bill WHERE dated='".$from."'" ;

  $Total=mysqli_query($conn,$TotalOrder_sql);//-------------------get total sum of todays sold orders
  
  while($row=mysqli_fetch_array($Total))
  {
  	$sale_name[]=$row;
  }


  $dateincrement = strtotime("+1 day", strtotime($from));
  $from = date("Y-m-d", $dateincrement);    
  if($from > $to){
  	break;
  }

}
$srno=0;

foreach ($sale_name as $key) {
	$srno++;
	$table_id=$key['table_id'];
	$table_no="---";
	$parcel_id="---";
	if($table_id=='-1'){
		$parcel_id='#P'.$key['parcel_id'];
	}
	else{
		$fetch_tableNO="SELECT * FROM hotel_tables WHERE table_id='$table_id'";
		$fetch_tableNO_result=mysqli_query($conn,$fetch_tableNO);

		while($row = mysqli_fetch_array( $fetch_tableNO_result))
		{
			$table_no='#T'.$row['table_name'];
		}

	}

	echo '

	<tr>
	<td>'.$srno.'.</td>
	<td>#'.$key['order_no'].'</td>
	<td>'.$table_no.'</td>
	<td>'.$parcel_id.'</td>
	<td>'.$key['revenue'].' <i class="fa fa-inr"></i></td>
	<td>'.$key['dated'].'</td>
	<td class="w3-text-grey">
		<a class="btn" target="_blank" href="report/invoiceCopy_print.php?order_no='.$key['order_no'].'" title="View Bill" style="margin-right:5px;padding:0px"><span class="fa fa-eye"></span>
		</a>
		<a class="btn fa fa-remove" onclick="deleteInvoice('.$key['order_no'].')" title="Delete Bill" style="padding:0px"></a>
	</td>

	</tr>
	
	';
}
echo '
</tbody>
</table>
';
//echo json_encode($sale_name);
?>

