<?php
//error_reporting(E_ERROR | E_PARSE);
include_once("../../db_conn/conn.php");
$order_no=$_GET['order_no'];
date_default_timezone_set('Asia/Kolkata');

?>

<html monomarginboxes mozdisallowselectionprint>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bill Payment-Copy</title>
  <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="../../assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="../../assets/css/w3.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/alert/jquery-confirm.css">
  <script type="text/javascript" src="../../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../../assets/css/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../assets/css/alert/jquery-confirm.js"></script>
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

     <b>Phone no:</b> <?php echo $cno; ?><br>
     <b>Mobile no:</b> <?php echo $cno2; ?><br>


   </div>
   <br>


   <h5 class = "text-center">Bill Details - Copy</h5>
   <div>

     <?php 
     $fetch_orders="SELECT * FROM order_table WHERE order_id='$order_no'";
     $fetch_orders_result=mysqli_query($conn,$fetch_orders);
     $items="";
     $item_rate="";
     $item_id="";
     $revenue="";

     while($row=mysqli_fetch_assoc($fetch_orders_result))
     {
      $items= $row['ordered_items'];
      $parcel_id= $row['parcel_id'];
      $table_id= $row['table_id'];
      $table_no= $row['table_no'];
    }
    $json=json_decode($items,true);

    $bill_fetch="SELECT * FROM order_bill WHERE order_no='$order_no'";
    $bill_fetch_result=mysqli_query($conn,$bill_fetch);
    while($order=mysqli_fetch_array($bill_fetch_result))
    {
      $revenue= $order['revenue'];
      $dated= $order['dated'];
    }
    ?>

    GST   NO: #<?php echo $gst;?><br>
    Order No: #<?php echo $order_no; ?><span class="w3-right">Date: <?php echo date("d M Y", strtotime($dated)); ?></span><br>      
  </div>
  <br>
  <?php
  if ($table_id=='-1') {
    echo '<h6 class = "text-center">Parcel P'.$parcel_id.' </h6>';
  }
  else{
    echo '<h6 class = "text-center">Table T'.$table_no.' </h6>';
  }
  ?>

  <table class="table borderless" >  
    <thead>  

      <th class='text-center' style ='border: 0;'>Product Name</th>  
      <th class='text-center' style ='border: 0;'>Price</th>  
      <th class='text-center' style ='border: 0;'>Quantity</th>  

      <th class='text-center' style ='border: 0;'>Amount</th>  

    </thead >  
    <?php

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
    $tax1_net=(($tax1_val/100)*$totalp);
    $tax2_net=(($tax2_val/100)*$totalp);
  
    $discount_value="";
    $rev_net="";
    $rev_net=$revenue -($tax1_net + $tax2_net); 
    $discount_value=$totalp -$rev_net; 
    $discount=($discount_value*100)/$totalp;     
    
  
   
    echo("<tr>");
    echo("<td colspan= class='text-center'><b>SUB-TOTAL</b></td>");  
    echo ("<td></td>");
    echo ("<td></td>");
    echo("<td class='text-center' style ='border:0;' ><b>".$totalp." &#x20A8</b></td>");
    echo("</tr>");

    echo("<tr>");
    echo("<td colspan= class='text-center' >Discount</td>");
    echo ("<td></td>");
    echo ("<td></td>");
    echo("<td class='text-center' style = >-".$discount." % (".$discount_value." Rs)</td>");
    echo("</tr>");

    echo("<tr>");
    echo("<td colspan= class='text-center' ><b>Grand Total</b></td>");
    echo ("<td></td>");
    echo ("<td></td>");
    echo("<td class='text-center' style = ><b>".$rev_net." &#x20A8</b></td>");
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
   echo("<td colspan= class='text-center'><b>TOTAL</b></td>");
   echo ("<td></td>");
   echo ("<td></td>");    
   echo("<td class='text-center' style = ><b>".$revenue." &#x20A8</b></td>");
   echo("</tr>");
   echo "</tbody> "; 

   

    // }
   mysqli_close($conn);
   ?>


 </tr>

</table> 

<center><i class="w3-center"> Inclusive of all taxes<br>
Thank you.Visit Again</i><br><br>
<span>[This is a duplicate bill copy for Order No: #<?php echo $order_no ?>. Taxes included in bill are according to present tax values provided by the Administrator of Hotel.]</span>
</center>
<div>
</div>

</div>

<div class = "col-sm-1 col-lg-3 col-md-1">
  <a name="b_print" id="b_print" type="btn btn-default" title="print" onclick="javascript:printdiv('container');" class="w3-button w3-text-red w3-card w3-large w3-margin-top fa fa-print"></a>
</div>
</div>

</body> 

</html>