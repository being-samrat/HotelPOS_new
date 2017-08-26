<?php
session_start();
include_once("../db_conn/conn.php");

if(!isset($_SESSION['waiter']))
{
  //$_SESSION['waiter']='';
  header("location:../index.php");

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>HOTEL POS</title>
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="../assets/css/w3.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>
  <style type="text/css">
    .table_view{
      background-image: url(admin/adminImg/empty.png);
      background-size: 40px;
      background-repeat: no-repeat;
      background-position: left;
      background-origin: content-box;
      padding-top:15px;
    }
    .tickBagde{
      position:absolute;
      margin:-5px 0 0 -5px;
      padding-left:5px;
      padding-right:5px
    }
  </style>

</head>
<body style="background-color: #E4E4E4;font-family:Segoe UI;letter-spacing:1px;">
  <!-- Top container -->
  <div class="w3-bar w3-top w3-red w3-large container_size" style="z-index:4">
  <span class="w3-bar-item w3-left w3-xlarge">HOTEL POS</span>
  <a href="waiter_logout.php" id="waiter_logout" name="waiter_logout" class="btn w3-text-white w3-padding-small w3-right fa fa-sign-out w3-small"> Logout</a>
  </div>

  

  <div class="w3-main" style="margin-top:55px;">
  
    <div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
    
    <div class="col-lg-4 col-md-4 col-sm-6" style="padding-right: 0px">
      <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px;max-height: 300px;overflow-y: scroll" id="vacant_div">
        <!-- Header -->
        <header class="w3-container ">
          <h5><b><i class="fa fa-bookmark"></i> Vacant Tables</b></h5>
        </header>
        <?php  
        $fetch_tables="SELECT * FROM hotel_tables WHERE occupied=0";
        $fetch_tables_result=mysqli_query($conn,$fetch_tables);
        
        while($row = mysqli_fetch_array( $fetch_tables_result))
        {
          $ac_Stat="NonA/C";
          if($row['status'] == '1'){
            $ac_Stat="A/C";
          }
          echo '
          <div class="w3-col l4 w3-col s6 w3-margin-bottom ">
            <span class="w3-small w3-right w3-text-white w3-padding-tiny">
              <span>'.$ac_Stat.'</span>

              <a class="fa fa-refresh" onclick="clear_status('.$row['table_id'].','.$row['table_name'].')"></a>
            </span>
            <div class="w3-container w3-padding-xlarge w3-card-8 w3-round-large" id="vacant_table_order" style="background-color:#79E40D;padding:0px">
              <div class="w3-center w3-circle w3-padding-tiny" id="'.$row['table_id'].'" style="border:4px solid white;"><span class="w3-large w3-text-white"><a class="btn w3-padding-tiny" href="waiter_home.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'" style="margin:6px 0 6px 0;">#'.$row['table_name'].'</a></span></div>

            </div>
          </div>';
        }   

        ?>

      </div>  

      <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px;max-height: 300px;overflow-y: scroll" id="occupied_div">
        <!-- Header -->
        <header class="w3-container ">
          <h5><b><i class="fa fa-users"></i> Occupied Tables</b></h5>
        </header>
        <?php  
        $fetch_tables="SELECT * FROM hotel_tables WHERE occupied!='0'";
        $fetch_tables_result=mysqli_query($conn,$fetch_tables);
        
        while($row = mysqli_fetch_array( $fetch_tables_result))
        {
          $parent_joined_color="w3-red";
          $parent_joined_hide="";
          if(($row['join_id']) > '0'){
            $parent_joined_color="w3-orange";

          }
          if(($row['join_id']) < '0'){
            $parent_joined_color="w3-red";

          }
          if(($row['join_id']) == '0'){
            $parent_joined_hide="w3-hide";

          }
          $ac_Stat="NonA/C";
          if($row['status'] == '1'){
            $ac_Stat="A/C";
          }
          include("../admin/bill/billPrinted.php");
          echo '<div class="w3-col l4 w3-col s6 w3-margin-bottom '.$parent_joined_hide.'">
          <span class="w3-badge tickBagde w3-small w3-green '.$show_checked.'">&#10004;</span>
          <span class="w3-small w3-right w3-text-white w3-padding-tiny">
            <span>'.$ac_Stat.'</span>

            <a class="fa fa-refresh" onclick="clear_status('.$row['table_id'].','.$row['table_name'].')"></a>
          </span>
          <div class="w3-container w3-padding-xlarge '.$parent_joined_color.' w3-card-8 w3-round-large" id="occupied_table_order" style="padding:0px">
            <div class="w3-center w3-circle w3-padding-tiny" id="'.$row['table_id'].'" style="border:4px solid white;">
              <span class="w3-large w3-text-white">
                <a class="btn w3-padding-tiny" href="waiter_home.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'" style="margin:6px 0 6px 0;">#'.$row['table_name'].'</a>
              </span>
            </div>
            
          </div>
        </div>';

      }   

      ?>

    </div>    
  </div>
  <div class="col-lg-8 col-md-8 col-sm-6" id="waiter_operation">
    <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px">
      <header class="w3-container ">
        <h5><b><i class="fa fa-bookmark"></i> Order for Table No: </b></h5>
      </header>

        <div id="per_table_order">

        <?php   
        if(isset($_GET['table_id'])) {
          include("per_table_order.php"); }?>
        </div>
        <div class="w3-display-bottomright" style="position: fixed">
      <a class="w3-border-top btn w3-red w3-large w3-round-xlarge w3-card-16" id="join_tab" title="Join tables" href="join_table.php" style="margin:8px"><i class="fa fa-link" ></i> <span class="w3-hide-small">Join Tables</span></a>
    </div>
      </div>      
    </div>

  </div>

<script>
  $(function() {
    $("#join_tab").click(function(e) {
        e.preventDefault(); //so the browser doesn't follow the link

        $("#waiter_operation").load(this.href, function() {
            //execute here after load completed
          });
      });
  });
</script>

<script>

  $(document).ready(function() {
  $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
  setInterval(function() {
    $('#occupied_div').load('occupied_tab.php');
  }, 3000); // the "3000" 
});

</script>
<script>

  $(document).ready(function() {
  $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
  setInterval(function() {
    $('#vacant_div').load('vacant_tab.php');
  }, 3000); // the "3000" 
});

</script>
<script>

  function clear_status(id,name){
    $.confirm({
      title: '<label class="w3-label w3-large">Clear Table Order!</label>',
      content: 'Ensure that the bill is printed before clearing the respective Table Order!!!',
      buttons: {
        confirm: function () {
          var dataS = 'id='+ id +'&no='+ name;
          $.ajax({
          url:"clearStatus.php", //the page containing php script
          type: "POST", //request type
          data: dataS,
          cache: false,
          success:function(html){
            $.alert(html);          
          }
        });

        },
        cancel: function () {

        }
      }
    });

  }

</script>
</body>
</html>
