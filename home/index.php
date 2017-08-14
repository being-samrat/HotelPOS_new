
<?php
include_once("db_conn/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>HOTEL POS</title>
  <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="assets/css/w3.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/alert/jquery-confirm.css">
  <script type="text/javascript" src="assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="assets/css/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/css/alert/jquery-confirm.js"></script>
  <style type="text/css">
    .table_view{
      background-image: url(admin/adminImg/empty.png);
      background-size: 40px;
      background-repeat: no-repeat;
      background-position: left;
      background-origin: content-box;
      padding-top:15px;
    }
  </style>

</head>
<body style="background-color: #E4E4E4">
  <!-- Top container -->
  <div class="w3-bar w3-top w3-red w3-large container_size" style="z-index:4">
    <button data-toggle="modal" data-target="#admin_login" type="button" class="w3-round-xxlarge w3-margin w3-text-grey w3-button" style="background-color: #E4E4E4;"><span class="fa fa-user"></span> Admin</button>
    <span class="w3-bar-item w3-right w3-xlarge">HOTEL POS</span>
  </div>

  <!-- Modal -->
  <div id="admin_login" class="modal fade " role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content col-lg-6 col-md-4 col-sm-12 col-lg-offset-3 col-md-offset-3">    
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <span class="w3-display-topmiddle w3-jumbo w3-circle"><i class=" w3-circle w3-blue fa fa-user-circle" style="border:2px solid red"></i></span>
        <div class="modal-body" style="margin-top: 80px">
          <hr>

          <form action="admin_login.php" id="form_admin_login"   method="POST">
            <select id="role" name="role" class="form-control w3-margin-bottom" required>
              <option selected>Select your role</option>
              <option value="Cashier">Cashier</option>
              <option value="Administrator">Administrator</option>
            </select>
            <input class="form-control " type="text" name="admin_name" placeholder="Username Eg:XYZ" required/><br>
            <input class="form-control" type="password" name="admin_passwd" placeholder="Password Eg:**********" required/><br>
            <input class="form-control w3-red w3-wide" type="submit" name="table_submit" id="table_submit" value="Login" >

            
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--modal end-->

  <div class="w3-main " style="margin-top:55px;">
    <div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
    
    <div class="col-lg-4 col-md-4 col-sm-6" style="padding-right: 0px">
      <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px;" id="vacant_div">
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
            <div class="w3-container w3-padding-xlarge w3-card-8 w3-round-large" id="vacant_table_order" style="background-color:#79E40D">
              <div class="w3-left w3-circle w3-padding-small" id="'.$row['table_id'].'" style="border:4px solid white;"><span class="w3-large w3-text-white"><a class="btn w3-padding-tiny" href="index.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'">#'.$row['table_name'].'</a></span>
              </div>

            </div>
          </div>';
        }   

        ?>

      </div>  

      <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px" id="occupied_div">
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
          echo '<div class="w3-col l4 w3-col s6 w3-margin-bottom '.$parent_joined_hide.'">
          <span class="w3-small w3-right w3-text-white w3-padding-tiny">
            <span>'.$ac_Stat.'</span>

            <a class="fa fa-refresh" onclick="clear_status('.$row['table_id'].','.$row['table_name'].')"></a>
          </span>
          <div class="w3-container w3-padding-xlarge '.$parent_joined_color.' w3-card-8 w3-round-large" id="occupied_table_order" >
            <div class="w3-left w3-circle w3-padding-small" id="'.$row['table_id'].'" style="border:4px solid white;">
              <span class="w3-large w3-text-white">
                <a class="btn w3-padding-tiny" href="index.php?table_id='.$row['table_id'].'&table_no='.$row['table_name'].'">#'.$row['table_name'].'</a>
              </span>
            </div>
            
          </div>
        </div>';

      }   

      ?>

    </div>    
  </div>
  <div class="col-lg-8 col-md-8 col-sm-6">
    <div class="w3-row-padding w3-margin-bottom" style="background-color: white;min-width: 300px">
      <header class="w3-container ">
        <h5><b><i class="fa fa-bookmark"></i> Order for Table No: </b></h5>
      </header>
      <div id="per_table_order">

        <?php   
        if(isset($_GET['table_id'])) {
          include("per_table_order.php"); }?>
        </div>
      </div>      
    </div>

  </div>
</div>
<!-- <script>
  $(function() {
    $("#occupied_table_order >div >span >a").click(function(e) {
        e.preventDefault(); //so the browser doesn't follow the link

        $("#per_table_order").load(this.href, function() {
            //execute here after load completed
          });
      });
  });
</script>
<script>
  $(function() {
    $("#vacant_table_order >div >span >a").click(function(e) {
        e.preventDefault(); //so the browser doesn't follow the link

        $("#per_table_order").load(this.href, function() {
            //execute here after load completed
          });
      });
  });
</script> -->
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
