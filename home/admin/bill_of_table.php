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
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
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
     $servicetax = "";
     $service = "";
     $vatname = "";
     $vat = "";
     $status1 = "";
     $status2 = "";
     while($row = mysqli_fetch_array( $bill_sql_res))
     { 
      $name=$row['hotel_name'];
      $addr=$row['hotel_addr'];
      $gst=$row['gst'];
      $servicetax = $row['servicetaxname'];
      $service = $row['service_tax'];
      $vatname = $row['vatname'];
      $vat = $row['vat'];
      $status1 = $row['status1'];
      $status2 = $row['status2'];
      $cno=$row['contact_no'];
      $cno2=$row['mobile_no'];
      $bill_id=$row['bill_id'];
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
       

       while($row=mysqli_fetch_assoc($fetch_orders_result))
       {

        $items= $row['ordered_items'];
        $order_id= $row['order_id'];
        $table_no= $row['table_no'];


      }
      $json=json_decode($items,true);
      

      ?>

      <?php $order_no=$order_id; ?>
      GST   NO: #<?php echo $gst; ?><br>
      Order No: #<?php echo $order_id; ?><br>
      Order By: #<?php echo $order_by; ?><span style = "float:right"><?php echo date("d M Y H:i"); ?></span><br>

      
    </div>

    <br>
    <h6 class = "text-center">Table T<?php echo $table_no." "; 
      foreach($json_join as $k){
        $join_tno="SELECT * FROM hotel_tables WHERE table_id='$k'";
        $join_tno_res=mysqli_query($conn,$join_tno);

        while($row = mysqli_fetch_array( $join_tno_res))
        { 
          echo "Table ".$row['table_name']." ";
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
      $servicetax_net=(($servicetax/100)*$totalp);
      $vat_net=(($vat/100)*$totalp);

      $net_total=$totalp + ($servicetax_net + $vat_net);
 $hide="";
      if(isset($_POST['discount'])){
        $hide="w3-hide";
       $dis = $_POST['discount'];
       $final = (($dis/100)*$totalp);

       $net_total  = $net_total -$final;

      }
      echo("<tr>");
      echo("<td colspan= class='text-center'><b>SUB-TOTAL</b></td>");  
      echo ("<td></td>");
      echo ("<td></td>");

      echo("<td class='text-center w3-border-top' style ='border:0;' ><b>". $totalp." &#x20A8</b></td>");
      echo("</tr>");

      echo("<tr>");
      echo("<td colspan= class='text-center' >extra</td>");
      echo ("<td></td>");
      echo ("<td></td>");
      echo("<td class='text-right' style = ></td>");
      echo("</tr>");

      if($status1 == 1){


       echo("<tr>");
       echo("<td colspan= class='text-center' >".$servicetax." (".$service."%)</td>");
       echo ("<td></td>");
       echo ("<td></td>");
       echo("<td class='text-right' style = >".$servicetax_net." &#x20A8</td>");
       echo("</tr>");
       

     }

     if($status2 == 1){

       echo("<tr>");
       echo("<td colspan= class='text-center' >".$vatname." (".$vat."%)</td>");
       echo ("<td></td>");
       echo ("<td></td>");
       echo("<td class='text-right' style = >".$vat_net." &#x20A8</td>");
       echo("</tr>");


     }
     
     

     
     echo("<tr>");
     echo("<td colspan= class='text-center'><b>TOTAL</b></td>");
     echo ("<td></td>");
     echo ("<td></td>");    
     echo("<td class='text-right' style = ><b>".$net_total." &#x20A8</b></td>");
     echo("</tr>");
     echo "</tbody> "; 

     $dated=date("d/m/y");
     $month=date("m");
     
    mysqli_close($conn);
    ?>


  </tr>
  <div class="<?php echo $hide; ?> w3-center w3-light-grey">
  <form method = "POST" >
    <label class="w3-medium">Discount (in %):</label>&nbsp;<input type = "text" name = "discount" autofocus>
    <input type = "submit"  name = "submit" value = "submit" >
  </form>
</div>
</table> 

<center><i class="w3-center"> Inclusive of all taxes<br>
  Thank you.Visit Again</i></center>
  <div>



    

  </div>

</div>
<div class = "col-sm-1 col-lg-3 col-md-1">
<input name="b_print" id="b_print" type="button" class="w3-button w3-red w3-wide w3-margin-top" onClick="javascript:printdiv('container')" value=" Print"  > 
<input name="discount_refresh" id="discount_refresh" type="button" class="w3-button w3-red w3-wide w3-margin-top" onClick="window.location.href=window.location.href" value=" Reset Discount"  > 
</div>
</div>
</body>
</html>