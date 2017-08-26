	<html>
  <head>
   <link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
   <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
   <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
   <script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>
 </head>
 </html>
 <?php
 include_once("../db_conn/conn.php");
 error_reporting(E_ERROR | E_PARSE);

 session_start();

 if (isset($_POST['table_submit'])) {

   $next_TABLE_ID = $_POST['shift_table'];
   $previous_table_ID = $_POST['previouse_table_id'];
   $next_TABLE_NO = "";
   $previous_table_NAME = "";
   $join_id='-1';

   // get previous table id by table name.............................................
   $sql = "SELECT *  FROM hotel_tables WHERE  table_id = $previous_table_ID";
   $sql_TABLE_NAME = mysqli_query($conn,$sql);
   while($row = mysqli_fetch_array($sql_TABLE_NAME)){

     $previous_table_NAME=$row['table_name'];

     if($row['join_id']!='-1'){
        $join_id=$row['join_id'];
        // echo $join_id;
        // die();
     }

   }

   //get next table id by table name.................................................
   $nxt_sql = "SELECT *  FROM hotel_tables WHERE  table_id = $next_TABLE_ID";
   $nxt_sql_TABLE_NAME = mysqli_query($conn,$nxt_sql);
   while($row = mysqli_fetch_array($nxt_sql_TABLE_NAME)){

     $next_TABLE_NO=$row['table_name'];
   }


   //unoccupy previous table .....................................
   $sql = "UPDATE  hotel_tables SET occupied = '0', join_id='-1' WHERE table_id ='$previous_table_ID' ";
   $vacantresult = mysqli_query($conn,$sql);
   if($vacantresult){

    $sql = "UPDATE hotel_tables SET occupied = '1', join_id='$join_id' WHERE table_id = '$next_TABLE_ID'";   //make next table occupy ..........................    
    $occupiedresult = mysqli_query($conn,$sql);
  }


  //script to replace kot id of previous table to next table........................................
  $sql1 = "SELECT * FROM kot_table where table_id = $previous_table_ID AND print_status='1'";
  $sql_TABLE_NAME1 = mysqli_query($conn,$sql1); 
  $kot_id  = "";
  while($row = mysqli_fetch_array($sql_TABLE_NAME1)){

    $kot_id   = $row['kot_id'];

    $sql = "UPDATE kot_table SET table_id ='$next_TABLE_ID' , table_no = '$next_TABLE_NO' WHERE  kot_id = $kot_id";
    $kotshowdata = mysqli_query($conn,$sql);       
  }
  

  $kot_change_sql1 = "UPDATE hotel_tables SET kot_open = 0 WHERE table_id = $previous_table_ID ";
  $result_kot_change = mysqli_query($conn,$kot_change_sql1);
  $kot_change_sql2 = "UPDATE hotel_tables SET kot_open = 1 WHERE table_id =  $next_TABLE_ID";
  $result_kot_change1 = mysqli_query($conn,$kot_change_sql2);


  $joinTable_change_sql2 = "UPDATE join_table SET table_id = '$next_TABLE_ID'  WHERE table_id =  '$previous_table_ID' AND joined='1'";
  mysqli_query($conn,$joinTable_change_sql2);
  
  

  $sql2 = "SELECT * FROM order_table where table_id = '$previous_table_ID' AND order_open='1'";
  $sql_TABLE_NAME2 = mysqli_query($conn,$sql2);  
  $order_id  = "";
  while($row = mysqli_fetch_array($sql_TABLE_NAME2)){

    $order_id   = $row['order_id'];

    $sql = "UPDATE order_table SET table_id ='$next_TABLE_ID' , table_no = '$next_TABLE_NO' WHERE  order_id = $order_id";
    $ordershowdata = mysqli_query($conn,$sql);       
  }

  echo "<script>
  $.alert({
    
    content: 'Table ".$previous_table_NAME." shifted to Table ".$next_TABLE_NO." !',
    
  });
  window.location.href='waiter_home.php?table_id=".$next_TABLE_ID."&table_no=".$next_TABLE_NO."';</script>";
  
}

?>

