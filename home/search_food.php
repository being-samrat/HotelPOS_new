<?php
    
	include_once("db_conn/conn.php");
    if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM menu_items WHERE item_name LIKE '%".$_POST["query"]."%'";  
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
           $output .= '<li class="searchLI">Food Item Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
?>
