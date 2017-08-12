<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../../db_conn/conn.php")
?>
<?php 
$fetch_parcels="SELECT * FROM parcel_table WHERE parcel_open=1 OR new_parcel=1 ORDER BY parcel_id DESC";
$fetch_parcels_result=mysqli_query($conn,$fetch_parcels);
$count=0;

while($row = mysqli_fetch_array( $fetch_parcels_result))
{
	$color="w3-red";
	$parcelBy=$row['parcelBy'];
	$parcel_id=$row['parcel_id'];

	if (($row['new_parcel']==1)) {
                  # code...
		$color="w3-green";
	}

	echo '
	<div class="w3-col l3 s4 w3-margin">
		<button type="button" class="close w3-padding-tiny w3-text-black" title="Delete Parcel" onclick="delParcel('.$row['parcel_id'].')">&times;</button>

		<div class="w3-container '.$color.' w3-padding-12 w3-card-4 w3-round-large">
			<div class="w3-center" id="'.$parcel_id.'" >
				<a class=" w3-wide" href="parcelOrder.php?parcel_id='.$parcel_id.'&parcelBy='.$parcelBy.'"><span class="w3-large" title="Parcel No. '.$parcel_id.'">#P'.$parcel_id.'</span></a>
			</div>						
		</div>
	</div>';

}   

?>