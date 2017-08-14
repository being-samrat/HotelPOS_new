<?php
    //error_reporting(E_ERROR | E_PARSE);
include_once("db_conn/conn.php");
if(isset($_POST["query"]))  
{  
  $stat="0";
  if(isset($_POST["tid"])){
    $table_id=$_POST["tid"];

    $sql = "SELECT status from hotel_tables where table_id = '$table_id'";
    $result = mysqli_query($conn, $sql);  
    while($row = mysqli_fetch_array($result)){

     $stat = $row['status'];

   }
 }

 $output = '';  
 $query = "SELECT * FROM menu_items WHERE status = '$stat' AND item_name LIKE '%".$_POST["query"]."%'";  
 $result = mysqli_query($conn, $query);  
 $output = '<ul class="list-unstyled searchUL">';  
 if(mysqli_num_rows($result) > 0)  
 {  
   while($row = mysqli_fetch_array($result))  
   {  
    $output .= '<li class="w3-padding-left w3-border " id="'.$row["item_id"].'">'.$row["item_name"].''.$stat.'</li>';  
  }  
}  
else  
{  
 $output .= '<li class="searchLI">Food Item Not Found</li>';  
}  
$output .= '</ul>';  
echo $output;  
}  
?>
