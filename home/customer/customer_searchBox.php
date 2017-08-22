<?php
//error_reporting(E_ERROR | E_PARSE);
session_start();
include_once("../db_conn/conn.php");
?>

<?php
if(isset($_POST["query"]))  
{  
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

      $output .= '<div class="w3-quarter w3-margin-bottom">
      <div class="w3-white" style="height: 380px;padding: 0spx;font-family:Segoe UI;letter-spacing:1px;">
        <div class="w3-col l12" >
          <div class="w3-white w3-opacity img_opaque"></div>
          <img src="images/onepage_restaurant.jpg" height="200px" width="100%">
        </div>
        <div class="w3-container w3-col s12 w3-large" style="font-weight: bolder;padding:5px 2px 0 10px">
          <span>'.$row['item_name'].'</span>
        </div>        
        <div class="w3-col s12 w3-col s12 w3-small" style="padding:5px 2px 0 10px">
          <div class="w3-col s12 w3-col s12" data-toggle="toggle" id="more_'.$row['item_id'].'" style="max-height: 40px;overflow-y: hidden;margin-bottom:0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo onsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </div>
          <a class="btn w3-text-red w3-right w3-margin-right more_style" style="font-weight:bold" onClick="more('.$row['item_id'].')">..more</a>   
        </div>  
        <div class="w3-col l12 w3-col s12 w3-margin-top" >               
          <div class="w3-col l6 w3-col s6" style="padding:5px 2px 0 10px">
            <span class="w3-left">Quantity : <input class=" " type="number" placeholder="count" id="quantity_'.$row['item_id'].'" value="1" style="width:35px"></span>
          </div>          
          <div class="w3-col l6 w3-col s6" style="padding:0px 10px 0 2px">                 
            <span class="w3-right w3-xlarge"><b>'.$row['item_price'].'<i class="fa fa-inr"></i></b></span><br>
            <span class="w3-right w3-tiny">(each)</span>

            <input type="hidden" id="name_'.$row['item_id'].'" value="'.$row['item_name'].'">
            <input type="hidden" id="price_'.$row['item_id'].'" value="'.$row['item_price'].'">
          </div>  
        </div>   
        <div class="w3-col l12 w3-center" style="margin-top: 10px">
          <button type="button" class="w3-red w3-button form-control" onclick="addCart(\''.$item_ID.'\')" >Add To Basket</button>
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
}  
?>
