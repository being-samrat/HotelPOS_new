<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once("../db_conn/conn.php");
?>

<?php

$stat="0";

$table_id=$_SESSION['customer_table'];

$sql = "SELECT status from hotel_tables where table_id = '$table_id'";
$result = mysqli_query($conn, $sql);  
while($row = mysqli_fetch_array($result)){

 $stat = $row['status'];

} 

$output = ''; 

$query = "SELECT * FROM menu_items WHERE status = '$stat' AND visible='1' AND item_name LIKE '%".$_POST["query"]."%'";  


$result = mysqli_query($conn, $query);  
if(mysqli_num_rows($result) > 0)  
{  
  $item_ID="0";
  while($row = mysqli_fetch_array($result))  
  {  
    $item_ID=$row['item_id'];
    $item_NAME=$row['item_name'];
    $item_PRICE=$row['item_price'];
    $get_cat_sql="SELECT menu_category.cat_name FROM menu_category,menu_items WHERE menu_category.cat_id=menu_items.cat_id AND menu_items.item_id='$item_ID'";
    $get_cat_res=mysqli_query($conn,$get_cat_sql);
    $item_category="";
    while($cat_row = mysqli_fetch_array( $get_cat_res))
    {
      $item_category=$cat_row['cat_name'];
    }    

    $output .= '<div class="w3-col l3  w3-margin-bottom">
    <div class="w3-white" style="height: 380px;padding: 0px;font-family:Segoe UI;letter-spacing:1px;">
      <div class="w3-col l12" >
        <div class="w3-white w3-opacity img_opaque"></div>
        <img src="'.$row['item_image'].'" class="w3-border" height="200px" width="100%">
      </div>
      <div class="w3-col s12 w3-col s12 w3-small" style="padding:5px 2px 0 10px;font-weight:bold">
        <span class="w3-text-grey">'.$item_category.'</span>
      </div>
      <div class="w3-container w3-center w3-col s12 w3-large" style="font-weight: bolder;padding:0 2px 0 10px">
        <span>'.$row['item_name'].'</span>
      </div>        
      <div class="w3-col s12 w3-col s12 w3-small" style="padding:2px 2px 0 10px">
        <div class="w3-col s12 w3-col s12" data-placement="top" data-toggle="tooltip" title="'.$row['item_info'].'" style="height: 15px;overflow-y: hidden;margin-bottom:0">
         <i class="w3-text-grey">'.$row['item_info'].'</i>
       </div>
     </div>  
     <div class="w3-col l12 w3-col s12 w3-margin-top" >               
      <div class="w3-col l6 w3-col s6" style="padding:5px 2px 0 10px">
        <span class="w3-left w3-small">Quantity : <input class=" " type="number" placeholder="count" id="quantity_'.$row['item_id'].'" value="1" style="width:35px"></span>
      </div>          
      <div class="w3-col l6 w3-col s6" style="padding:0px 10px 0 2px">                 
        <span class="w3-right w3-xlarge"><b>'.$row['item_price'].'<i class="fa fa-inr"></i></b></span><br>

        <input type="hidden" id="name_'.$row['item_id'].'" value="'.$row['item_name'].'">
        <input type="hidden" id="price_'.$row['item_id'].'" value="'.$row['item_price'].'">
      </div>  
    </div>   
    <div class="w3-col l12 w3-center" style="margin-top: 10px">
    <button type="button" class="w3-red w3-button form-control fa fa-shopping-basket" onclick="addCart(\''.$item_ID.'\')" > Add To Basket</button>
    </div>
  </div>
</div>';
}  
}  
else  
{  
 $output .= '<div class="w3-text-red w3-center"><span class="w3-xxlarge">Food Item Not Found</span></div>';  
}  
echo $output;  

?>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>