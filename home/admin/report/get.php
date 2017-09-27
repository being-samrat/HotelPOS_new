<?php
      $from=$_GET['report_fromDate'];
      $to=$_GET['report_toDate'];
      $date1=date_create($from);
      $date2=date_create($to );
      $diff=date_diff($date1,$date2);
      $between_dates=$diff->format("%a");
      $between_dates += 1;
      $item_array=array();
      $id_arr=array();
      $order_item="";
      $today=date("Y-m-d");

      $totalSale = "0";
      $count=0;
      for($i=0;$i<$between_dates;$i++){           
        $TotalOrderSale_sql="SELECT ordered_items FROM order_table WHERE date_time='".$from."'" ;
            $TotalSale=mysqli_query($conn,$TotalOrderSale_sql);//-------------------get total sum of todays sold orders  
            while($row=mysqli_fetch_array($TotalSale))
            {
              $ordered_items_list=$row['ordered_items'];
              $ordered_itemArr=json_decode($ordered_items_list,true);
              $order_item=$ordered_itemArr;

              foreach ($ordered_itemArr as $key=>$value) {                
                
                $id_arr[]=$value['item_id'];
                
            }
            
            }
            
            $dateincrement = strtotime("+1 day", strtotime($from));
            $from = date("Y-m-d", $dateincrement);    
            if($from > $to){
              break;
            }
//print_r($order_item);
          
          }
?>