	<html>
  <head>
   <link rel="stylesheet" href="assets/css/alert/jquery-confirm.css">
   <script type="text/javascript" src="assets/css/bootstrap/jquery-3.1.1.js"></script>
   <script type="text/javascript" src="assets/css/bootstrap/bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/css/alert/jquery-confirm.js"></script>
 </head>
 </html>
 <?php
 include_once("db_conn/conn.php");
 session_start();

 if (isset($_POST['table_submit'])) {

   $next_TABLE_ID = $_POST['shift_table'];
   $previous_table_NAME = $_POST['previouse_table_name'];

   $next_TABLE_NO = "";
   $previous_TABLE_ID = "";

   $sql = "SELECT *  FROM hotel_tables WHERE  table_name = $previous_table_NAME";
   $sql_TABLE_NAME = mysqli_query($conn,$sql);
   while($row = mysqli_fetch_array($sql_TABLE_NAME)){

     $prev_table_ID=$row['table_id'];
   }

   $nxt_sql = "SELECT *  FROM hotel_tables WHERE  table_id = $next_TABLE_ID";
   $nxt_sql_TABLE_NAME = mysqli_query($conn,$nxt_sql);
   while($row = mysqli_fetch_array($nxt_sql_TABLE_NAME)){

     $next_TABLE_NO=$row['table_name'];
   }

   $sql = "UPDATE  hotel_tables SET occupied = '0' WHERE table_id ='$prev_table_ID' ";
   $vacantresult = mysqli_query($conn,$sql);

   if($vacantresult){
     
    $sql = "UPDATE hotel_tables SET occupied = '1' WHERE table_id = '$next_TABLE_ID'";
    
    $occupiedresult = mysqli_query($conn,$sql);

  }

  $sql1 = "SELECT * FROM kot_table where table_id = $prev_table_ID AND print_status='1'";

  $sql_TABLE_NAME1 = mysqli_query($conn,$sql1);
    // echo $sql_TABLE_NAME;
    // die();
  $kot_id  = "";
  while($row = mysqli_fetch_array($sql_TABLE_NAME1)){

    $kot_id   = $row['kot_id'];

    $sql = "UPDATE kot_table SET table_id ='$next_TABLE_ID' , table_no = '$next_TABLE_NO' WHERE  kot_id = $kot_id";
    $kotshowdata = mysqli_query($conn,$sql);       
  }
  

  $kot_change_sql1 = "UPDATE hotel_tables SET kot_open = 0 WHERE table_id = $prev_table_ID ";
  $result_kot_change = mysqli_query($conn,$kot_change_sql1);
  $kot_change_sql2 = "UPDATE hotel_tables SET kot_open = 1 WHERE table_id =  $next_TABLE_ID";
  $result_kot_change1 = mysqli_query($conn,$kot_change_sql2);
  
  

  $sql2 = "SELECT * FROM order_table where table_id = '$prev_table_ID' AND order_open='1'";

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
  window.location.href='index.php';</script>";
  
}

?>

