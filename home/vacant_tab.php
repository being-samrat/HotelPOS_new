

<header class="w3-container ">
  <h5><b><i class="fa fa-bookmark"></i> Vacant Tables</b></h5>
</header>
<?php  
include_once("db_conn/conn.php");

$fetch_tables="SELECT * FROM hotel_tables WHERE occupied=0";
$fetch_tables_result=mysqli_query($conn,$fetch_tables);

while($row = mysqli_fetch_array( $fetch_tables_result))
{
  $ac_Stat="NonA/C";
  if($row['status'] == '1'){
    $ac_Stat="A/C";
  }
  echo '
  <div class="w3-col l4 w3-col s6 w3-margin-bottom ">
    <span class="w3-small w3-right w3-text-white w3-padding-tiny">
      <span>'.$ac_Stat.'</span>
      <a class="fa fa-refresh" onclick="clear_status('.$row['table_id'].','.$row['table_name'].')"></a>
    </span>
    <div class="w3-container w3-padding-xlarge w3-card-8 w3-round-large" id="vacant_table_order" style="background-color:#79E40D">
      <div class="w3-left w3-circle w3-padding-small" id="'.$row['table_id'].'" style="border:4px solid white;"><span class="w3-large w3-text-white"><a class="btn w3-padding-tiny" href="index.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'">#'.$row['table_name'].'</a></span></div>

    </div>
  </div>';
}   


?>


