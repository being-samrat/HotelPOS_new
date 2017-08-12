<?php
    include("db_conn/conn2.php");
    $i="";
    $query=mysqli_query($conn,"SELECT * FROM kot_table WHERE table_id='7' AND print_status='1'");
    while($row=mysqli_fetch_assoc($query))
    {
    	
      $i= $row['kot_items'];
          

    }
    $s=json_decode($i,true);
    foreach ($s as $row) {
    	echo $row['item_name']." ";

    }
      
?>