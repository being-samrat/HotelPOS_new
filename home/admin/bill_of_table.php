<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once("../db_conn/conn.php");
$order_by="";
if(isset($_SESSION['admin_passwd']))
{
  $order_by=$_SESSION['admin_passwd'];
}
else{
  $order_by=$_SESSION['cashier'];
}
date_default_timezone_set('Asia/Kolkata');

?>

<html monomarginboxes mozdisallowselectionprint>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bill Payment</title>
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="../assets/css/w3.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>
  <style type="text/css" media="print">
    body { blue;margin: 10mm 8mm 10mm 8mm;
    }
    html {background-color: #FFFFFF;margin: 0px; 
    }


    @page {size:auto letter; 
      margin: 0mm; }

    </style>

    <script>

      function printdiv(printpage)
      {
        var headstr = "<html><head></head><body></body>";

        var footstr = "</body>";

        var newstr = document.all.item(printpage).innerHTML;

        var oldstr = document.body.innerHTML;
        document.body.innerHTML = headstr+newstr+footstr;
        window.print();
        document.body.innerHTML = oldstr;
        return false;


      }
    </script>

  </head>

  <body style="font-family: serif;font-size: 80%;">

    <?php
    $table_no= $_GET['table_no'];
    $table_id= $_GET['table_id'];
    ?>
    <!-- ///////////////////////////////////get table names from join table by json decoding/////////// -->

    <?php 
    $get_tno="SELECT * FROM hotel_tables,join_table WHERE hotel_tables.join_id=join_table.join_id AND hotel_tables.table_id='$table_id'";
    $get_tno_res=mysqli_query($conn,$get_tno);

    $table_name="";
    $join_tabs="";
    $json_join="";
    while($row = mysqli_fetch_array( $get_tno_res))
    { 
      $join_tabs=$row['joint_tables'];
      $table_name=$row['table_name'];
    }
    $json_join=json_decode($join_tabs,true);
    
    ?>


    <!-- //////////////////////////////////   end -->
    <div>           
     <div class = "col-sm-1 col-lg-4 col-md-1 "> 

     </div>
     <?php 
     $bill_sql="SELECT * FROM bill_struct ORDER BY bill_id DESC LIMIT 1";
     $bill_sql_res=mysqli_query($conn,$bill_sql);

     $name="";
     $addr="";
     $gst="";
     $cno="";
     $bill_id="";
     $tax1_name = "";
     $tax1_val = "";
     $tax2_name = "";
     $tax2_val = "";
     $tax1_stat = "";
     $tax2_stat = "";
     while($row = mysqli_fetch_array( $bill_sql_res))
     { 
      $name=$row['hotel_name'];
      $addr=$row['hotel_addr'];
      $gst=$row['gst'];
      $tax1_name = $row['tax1_name'];
      $tax1_val = $row['tax1_value'];
      $tax2_name = $row['tax2_name'];
      $tax2_val = $row['tax2_value'];
      $tax1_stat = $row['tax1_status'];
      $tax2_stat = $row['tax2_status'];
      $cno=$row['contact_no'];
      $cno2=$row['mobile_no'];
      $bill_id=$row['bill_id'];
      $dated=date("Y-m-d");
      
    }
    ?>
    <div class = " col-sm-12 col-lg-4 col-md-3" id = "container">



      <h4 class = "text-center w3-wide w3-xxlarge"><?php echo $name; ?></h4> 

      <div class = "text-center "><?php echo $addr; ?><br>

       <b>phone no:</b> <?php echo $cno; ?><br>
       <b>mobile no:</b> <?php echo $cno2; ?><br>
       
       
     </div>
     <br>


     <h5 class = "text-center">Bill Details</h5>
     <div>

       <?php 
       $fetch_orders="SELECT * FROM order_table WHERE table_id='$table_id' AND order_open='1'";
       $fetch_orders_result=mysqli_query($conn,$fetch_orders);
       $items="";
       $item_rate="";
       $item_id="";
       $waiter="";

       while($row=mysqli_fetch_assoc($fetch_orders_result))
       {

        $items= $row['ordered_items'];
        $order_id= $row['order_id'];
        $table_no= $row['table_no'];
        $waiter=$row['waiter'];

      }
      $json=json_decode($items,true);
      

      ?>

      <?php $order_no=$order_id; ?>
      GST   NO: #<?php echo $gst; ?>
      <span style = "float:right">Order No: #<?php echo $order_id; ?></span><br>
      Order By: #<?php echo $order_by; ?>
    
      <?php if($waiter!=''){ ?>
      <br><span style = "float:left">Waiter : #<?php echo $waiter; ?></span>
      <?php } ?>
      <span style = "float:right"><?php echo date("d M Y [h:i a]"); ?></span><br>

      
    </div>

    <br>
    <h6 class = "text-center">Table T<?php echo $table_no." "; 
      foreach($json_join as $k){
        $join_tno="SELECT * FROM hotel_tables WHERE table_id='$k'";
        $join_tno_res=mysqli_query($conn,$join_tno);

        while($row = mysqli_fetch_array( $join_tno_res))
        { 
          echo "T".$row['table_name']." ";
        }
        
      }
      ?>
    </h6>
    <table class="table borderless" >  
      <thead>  

        <th class='text-center' style ='border: 0;'>Product Name</th>  
        <th class='text-center' style ='border: 0;'>Price</th>  
        <th class='text-center' style ='border: 0;'>Quantity</th>  

        <th class='text-center' style ='border: 0;'>Amount</th>  

      </thead >  
      <?php

      $bill_fetch_items="SELECT * FROM order_table WHERE table_id='$table_id' AND occupied='1'";
      $bill_fetch_items_result=mysqli_query($conn,$bill_fetch_items);
      $totalp = 0;
      foreach ($json as $row) {
        $total=$row['item_price'] * $row['quantity'];
        $item_name=$row['item_name'];
        $quantity=$row['quantity'];
        $item_price=$row['item_price'];

        echo     "<tbody style='font-family: serif;font-size: 60%;'>"; 

        echo "<tr style ='border: 0;'>";
        echo "<td class='text-center' style ='border:0;'>".$row['item_name']."</td>";
        echo "<td class='text-center' style ='border: 0;'>" .$row['item_price']. " &#x20A8</td>";
        echo "<td class='text-center' style ='border: 0;'>".$row['quantity']."</td>";
        $total  =  $row['item_price'] * $row['quantity'];

        echo("<td class='text-center' style ='border:0;'><b>".$total." &#x20A8 </b></td>");
        $totalp = $totalp + $total;        
        echo("</tr>");

      }

      //................................join table order.............................
      foreach($json_join as $join_bill){
        $join_table_order_sql="SELECT * FROM order_table WHERE table_id='$join_bill' AND order_open='1'";
        $join_table_order_res=mysqli_query($conn,$join_table_order_sql);

        while($join_bill = mysqli_fetch_array( $join_table_order_res))
        { 
          $join_items= $join_bill['ordered_items'];
        }

        $join_item_json=json_decode($join_items,true);
        foreach ($join_item_json as $j_items) {

          $join_item_name=$j_items['item_name'];
          $join_quantity=$j_items['quantity'];
          $join_item_price=$j_items['item_price'];

          echo "<tr style ='border: 0;'>";
          echo "<td class='text-center' style ='border:0;'>".$j_items['item_name']."</td>";
          echo "<td class='text-center' style ='border: 0;'>" .$j_items['item_price']. " &#x20A8</td>";
          echo "<td class='text-center' style ='border: 0;'>".$j_items['quantity']."</td>";
          $join_total=$j_items['item_price'] * $j_items['quantity'];

          echo("<td class='text-center' style ='border:0;'><b>".$join_total." &#x20A8 </b></td>");
          $totalp = $totalp + $join_total;        
          echo("</tr>");          
                  //echo $row['item_name']." ";

        }
      }
      //...............................................................
      
      $tax1_net=(($tax1_val/100)*$totalp);
      $tax2_net=(($tax2_val/100)*$totalp);

      
      $hide="";
      $show_btn="w3-hide";
      if(isset($_POST['discount'])){

        $hide="w3-hide";
        $show_btn="";
        $discount_value=0;
        $discount_type=$_POST['discount_type'];
        $discount_value = $_POST['discount'];

        switch ($discount_type) {
          case 'percentage':
          if($discount_value>100){
            echo "<span class='w3-text-red w3-large'>Discount Percentage value should be less than 100% !!!</span>";
          }
          else{
            $final = (($discount_value/100)*$totalp);
            $grand_total=$totalp -$final;
            $net_total=$grand_total + ($tax1_net + $tax2_net);  
          }
          
          break;

          case 'rupees':
          if($discount_value>$totalp){
            echo "<span class='w3-text-red w3-large'>Discount value should be less than SUB-TOTAL !!!</span>";
          }
          else{
            $final = $discount_value;
            $grand_total=$totalp -$final;
            $net_total=$grand_total + ($tax1_net + $tax2_net);
          }
          break;
          
          default:
            # code...
          break;
        }       

       //save bill into bill table
        $chkBill_exist_sql="SELECT * FROM order_bill WHERE order_no='$order_id'";
        $chkBill_exist_sql_result=mysqli_query($conn,$chkBill_exist_sql);
        $bill_count=mysqli_num_rows($chkBill_exist_sql_result);
        if ($bill_count == 0) 
        {
          $saveBill_sql="INSERT INTO order_bill (order_no,table_id,revenue,dated ) VALUES ('$order_id','$table_id','$net_total','$dated')";
          mysqli_query($conn ,$saveBill_sql);
          

          $print_ready_sql="UPDATE order_bill SET readyTo_print='1' WHERE order_no='$order_id'";
          mysqli_query($conn ,$print_ready_sql);
        }
        else{
    //if order exists, then just update modified revenue
          $saveBill_sql="UPDATE order_bill SET revenue='$net_total', dated='$dated' WHERE order_no='$order_id'";
          mysqli_query($conn ,$saveBill_sql);
          

          $print_ready_sql="UPDATE order_bill SET readyTo_print='1' WHERE order_no='$order_id'";
          mysqli_query($conn ,$print_ready_sql);
        }
  //----end
        
      }
      echo("<tr>");
      echo("<td colspan= class='text-center'><b>SUB-TOTAL</b></td>");  
      echo ("<td></td>");
      echo ("<td></td>");
      echo("<td class='text-center w3-border-top' style ='border:0;' ><b>". $totalp." &#x20A8</b></td>");
      echo("</tr>");

      echo("<tr>");
      echo("<td colspan= class='text-center' >Discount</td>");
      echo ("<td></td>");
      echo ("<td></td>");
      echo("<td class='text-center' style = >-".$final." &#x20A8</td>");
      echo("</tr>");

      echo("<tr>");
      echo("<td colspan= class='text-center' ><b>GRAND TOTAL</b></td>");
      echo ("<td></td>");
      echo ("<td></td>");
      echo("<td class='text-center' style = ><b>".$grand_total." &#x20A8</b></td>");
      echo("</tr>");

      echo("<tr>");
      echo("<td colspan= class='text-center' >extra</td>");
      echo ("<td></td>");
      echo ("<td></td>");
      echo("<td class='text-center' style = ></td>");
      echo("</tr>");

      if($tax1_stat == 1){


       echo("<tr>");
       echo("<td colspan= class='text-center' >".$tax1_name." (".$tax1_val."%)</td>");
       echo ("<td></td>");
       echo ("<td></td>");
       echo("<td class='text-center' style = >".$tax1_net." &#x20A8</td>");
       echo("</tr>");
       

     }

     if($tax2_stat == 1){

       echo("<tr>");
       echo("<td colspan= class='text-center' >".$tax2_name." (".$tax2_val."%)</td>");
       echo ("<td></td>");
       echo ("<td></td>");
       echo("<td class='text-center' style = >".$tax2_net." &#x20A8</td>");
       echo("</tr>");


     }
     
     

     
     echo("<tr>");
     echo("<td colspan= class='text-center'><b>NET PAYABLE AMOUNT</b></td>");
     echo ("<td></td>");
     echo ("<td></td>");    
     echo("<td class='text-center' style = ><b>".$net_total." &#x20A8</b></td>");
     echo("</tr>");
     echo "</tbody> "; 

     $dated=date("Y-m-d");
     
     ?>


   </tr>
   <div class="<?php echo $hide; ?> w3-center w3-light-grey" style="padding:0 60px 5px 60px">
    <form method = "POST">
      <div class="form-group ">
        <label class="w3-text-red">If no discount, then enter 0 and submit</label>
        <div class="input-group">
          <span class="input-group-addon">Discount</span>
          <input class="form-control" type="number" autocomplete="off" step="0.01" name="discount" autofocus>
          <span class="input-group-btn">
            <select name="discount_type" class="btn">
              <option value="percentage">in %</option>
              <option value="rupees">in Rs</option>
            </select>
          </span>
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit">submit!</button>
          </span>
        </div>
      </div>      
    </form>
  </div>
</table> 

<center><i class="w3-center"> Inclusive of all taxes<br>
  Thank you.Visit Again</i></center>
  <div>





  </div>

</div>
<div class = "col-sm-1 col-lg-3 col-md-1 <?php echo $show_btn; ?>">

  <a name="b_print" id="b_print" type="btn btn-default" title="print bill" onclick="javascript:printdiv('container');" class="w3-button w3-text-red w3-card w3-large w3-margin-top fa fa-print"></a>

  <input name="discount_refresh" id="discount_refresh" type="btn btn-default" class="w3-button w3-text-red w3-card w3-wide w3-margin-top" onClick="window.location.href=window.location.href" value=" Reset Discount"  > 
</div>
</div>
<?php
mysqli_close($conn);
?>
</body>
</html>