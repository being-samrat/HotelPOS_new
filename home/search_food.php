<?php
error_reporting(E_ERROR | E_PARSE);
include_once("db_conn/conn.php");
if(isset($_POST["query"]))  
{  
  $stat="0";
  if(isset($_POST["table_id"])){
    $table_id=$_POST["table_id"];

    $sql = "SELECT status from hotel_tables where table_id = '$table_id'";
    $result = mysqli_query($conn, $sql);  
    while($row = mysqli_fetch_array($result)){

     $stat = $row['status'];

   }
 }

 $output = '';  
 $query = "SELECT * FROM menu_items WHERE status = '$stat' AND visible='1' AND item_name LIKE '%".$_POST["query"]."%'";  
 $result = mysqli_query($conn, $query);  
 $output = '<ul class="list-unstyled searchUL">';  
 if(mysqli_num_rows($result) > 0)  
 {  
   while($row = mysqli_fetch_array($result))  
   {  
    $output .= '<li class="w3-padding-left w3-border " id="'.$row["item_id"].'">'.$row["item_name"].'</li>';  
  }  
}  
else  
{  
 $output .= '<label class="w3-text-red">Food Item Not Found</label>';  
}  
$output .= '</ul>';  
echo $output;  
}  
?>
