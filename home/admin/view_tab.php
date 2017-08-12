<?php  
include_once("../db_conn/conn.php");

$fetch_tables="SELECT * FROM hotel_tables ORDER BY table_name";
$fetch_tables_result=mysqli_query($conn,$fetch_tables);

while($row = mysqli_fetch_array( $fetch_tables_result))
{
	$table_name=$row['table_name'];
	$color="";
	$print="";
	$hide="";
	if (($row['occupied']==1)) {
									# code...
		$color="#ff9800";

		if (($row['join_id']=='-1')) {
			$color="#79E40D";
		}
	}

	if (($row['join_id']==0)) {
									# code...
		$hide="w3-hide";
	}

	if (($row['kot_open']==1)) {
									# code...
		$print="w3-text-yellow";
	}
	$ac_Stat="NonA/C";
	if($row['status'] == '1'){
		$ac_Stat="A/C";
	}
	$table_id=$row['table_id'];
	$kot_status="SELECT * FROM kot_table WHERE table_id='$table_id' AND print_status='1'";
	$kot_status_result=mysqli_query($conn,$kot_status);

	$kot_id="";
	while($row = mysqli_fetch_array( $kot_status_result))
	{

		$kot_id=$row['kot_id'];

	}


	echo '
	<div class="w3-col l3 s6 w3-margin-bottom '.$hide.'">
		<span class="w3-small w3-right w3-text-white w3-padding-tiny">
			<span>'.$ac_Stat.'</span>

			<a class="fa fa-refresh" onclick="clear_status('.$table_id.','.$table_name.')"></a>
		</span>
		<div class="w3-container w3-red w3-padding-16 w3-card-4 w3-round-large">
			<div class="w3-left w3-circle w3-padding-small" id="'.$table_id.'" style="border:4px solid'.$color.';"><span class="w3-large">#'.$table_name.'</span></div>
			<div class="w3-right">
				<span class="w3-small fa fa-first-order"> &nbsp;<a class="w3-wide" href="table_order.php?table_id='.$table_id.'&table_no='.$table_name.'">Order</a></span><br>

				<span class="w3-small fa fa-sticky-note"> &nbsp;<a class="w3-wide '.$print.'" target="blank" href="bill_of_kot.php?kot_id='.$kot_id.'&table_no='.$table_name.'&table_id='.$table_id.'" >Print KOT</a></span><br>

				<span class="w3-small fa fa-print">&nbsp;<a class="w3-wide" target="blank" href="bill_of_table.php?table_id='.$table_id.'&table_no='.$table_name.'" >Print Bill</a></span>          
			</div>

		</div>
	</div>';

}   

mysqli_close($conn);

?>