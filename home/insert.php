<?php
error_reporting(E_ERROR | E_PARSE);

include_once("db_conn/conn.php");
?>
<?php
                $from = $_POST['from'];
                $to  = $_POST['to'];
                $item =  $_POST['menuitem'];


                $sql =   "SELECT * from order_table where ordered_items like '%$item%' AND date_time between '$from' and '$to'";
                $result = mysqli_query($conn,$sql);
                $result1 = mysqli_num_rows($result);
               // echo $result1;
            
                 $count = "0";
                
                $items_array = array();
                while($row = mysqli_fetch_array($result))
                {
                 
                  $sql1 = "SELECT * FROM order_table WHERE  date_time = '$from'";

                  $result1 = mysqli_query($conn,$sql1);

                 while($row1 = mysqli_fetch_array($result1)){
               // echo $row1['date_time'];

                    $ordered_items  = $row1['ordered_items'];
                      $order_array=json_decode($ordered_items,true);
                                                                     
                            foreach($order_array as $k)
                            {  

                                
                                    if($k['item_name'] == $item)
                                    {
                                       $count = $count + $k['quantity'];

                                                                         
                                    }   

                              
                            }

                 }
             //   die();

                 $items_array[] = $count;
                  $count = "0";
           
                    $dateincrement = strtotime("+1 day", strtotime($from));
                    $from = date("Y-m-d", $dateincrement);    
           if($from > $to){
             break;

           }
                }
                   
                          print_r($items_array);
                  
         

                ?>