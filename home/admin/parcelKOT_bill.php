<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php");
$parcelBy=$_GET['parcelBy'];
$parcel_id=$_GET['parcel_id'];

date_default_timezone_set('Asia/Kolkata');

?>

<html monomarginboxes mozdisallowselectionprint>
<head>
  <title>Parcel KOT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

  <body >
    <div>           
     <div class = "col-sm-1 col-lg-3 col-md-1 "> 
      <span class="w3-medium w3-text-red w3-margin-top w3-light-grey"><b>NOTE:</b><br>Do not refresh the page before print.<br>Refreshing the page will clear the KOT details.</span>
     </div>

     <div class = " col-sm-5 col-lg-5 col-md-4" id = "container">

    
      <h5 class = "text-center">Parcel KOT Details</h5>
      <br>
      <span class = "w3-left">Parcel No.# <?php echo $parcel_id; ?></span>
      <br>
      <span class = "w3-left">Order By:<?php echo $parcelBy; ?></span>
      <span class = "w3-right"><?php echo date("d M Y [h:i a]"); ?></span>
      <table class="table borderless" >  
        <tbody style="font-family: serif;">
          <tr>
            <td></td>
            <td></td>
          </tr>
          <?php 
          $fetch_orders="SELECT * FROM kot_table WHERE parcel_id='$parcel_id' AND print_status=1";
          $fetch_orders_result=mysqli_query($conn,$fetch_orders);
          $items="";
          $item_rate="";
          $item_id="";


          while($row=mysqli_fetch_assoc($fetch_orders_result))
          {

            $items= $row['kot_items'];

            $json=json_decode($items,true);
            foreach ($json as $row) {
              echo '
              <tr>
                <td>'.$row['quantity'].'</td>
                <td>'.$row['item_name'].'</td>

              </tr>';
                
            }
          }



          $update_sql="UPDATE kot_table SET print_status='0' WHERE parcel_id='$parcel_id' AND print_status=1";          
          mysqli_query($conn,$update_sql);
          mysqli_close($conn);
          ?>

        </tbody>
      </table>       
      </div>
      <div class = "col-sm-3 col-lg-3 col-md-3">
 <input name="b_print" id="b_print" type="button" class="w3-button w3-red w3-wide w3-margin-top" onClick="javascript:printdiv('container')" value=" Print"  >  
      </div>
    </div>
   
    
  </body> 


  

</html>