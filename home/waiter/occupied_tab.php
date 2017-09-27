
<header class="w3-container ">
  <h5><b><i class="fa fa-users"></i> Occupied Tables</b></h5>
</header>
<?php  
include_once("../db_conn/conn.php");
$fetch_tables="SELECT * FROM hotel_tables WHERE occupied!='0'";
$fetch_tables_result=mysqli_query($conn,$fetch_tables);

while($row = mysqli_fetch_array( $fetch_tables_result))
{
  $parent_joined_color="w3-red";
  $parent_joined_hide="";
  if(($row['join_id']) > '0'){
    $parent_joined_color="w3-orange";

  }
  if(($row['join_id']) < '0'){
    $parent_joined_color="w3-red";

  }
  if(($row['join_id']) == '0'){
    $parent_joined_hide="w3-hide";

  }
  $ac_Stat="NonA/C";
  if($row['status'] == '1'){
    $ac_Stat="A/C";
  }

  include("../admin/bill/billPrinted.php");
  echo '<div class="w3-col l4 w3-col s6 w3-margin-bottom '.$parent_joined_hide.'">
  <span class="w3-badge tickBagde w3-small w3-green '.$show_checked.'">&#10004;</span>
  <span class="w3-small w3-right w3-text-white w3-padding-tiny">
    <span>'.$ac_Stat.'</span>
  </span>
  <div class="w3-container w3-padding-xlarge '.$parent_joined_color.' w3-card-8 w3-round-large" id="occupied_table_order" style="padding:0px">
    <div class="w3-center w3-circle w3-padding-tiny" id="'.$row['table_id'].'" style="border:4px solid white;">
      <span class="w3-large w3-text-white">
        <a class="btn w3-padding-tiny" href="waiter_home.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'" style="margin:6px 0 6px 0;">#'.$row['table_name'].'</a>
      </span>
    </div>
    
  </div>
</div>';

}   

?>


