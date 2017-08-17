 <?php  
 
 $fetch_printed_sql="SELECT * FROM order_bill WHERE table_id='".$row['table_id']."'";
 $fetch_printed_result=mysqli_query($conn,$fetch_printed_sql);
  $show_checked="w3-hide";
 while($order_row = mysqli_fetch_array( $fetch_printed_result))
 {  
  if(($order_row['readyTo_print']) > '0'){
    $show_checked="";
  }
}
?>