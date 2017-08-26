<?php
include_once("db_conn/conn.php");

$demosql="SELECT status FROM join_table";
$demores=mysqli_query($conn,$demosql);
if($demores==FALSE)
{
  $sql="ALTER TABLE join_table ADD joined BOOLEAN NOT NULL AFTER joint_tables; "
}
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
  <div class="w3-red w3-center" style="min-height: 100px">    
    <span class=" w3-jumbo">HOTEL POS</span>
  </div>
  <div class="col-lg-4 w3-hide-small"></div>
  <div class="col-lg-4 ">
    <div class="w3-padding-xxlarge w3-border well" style="margin-top: 40px">

      <select id="role" name="role" class="form-control w3-margin-bottom" required>
        <option class="w3-red" selected>Select your role</option>
        <option value="Cashier">Cashier</option>
        <option value="Customer">Customer</option>
        <option value="Waiter">Waiter</option>
        <option value="Administrator">Administrator</option>
      </select>
      <div id="Administrator" class="Hotel_role" style="display:none">
        <form action="admin_login.php" id="form_admin_login" class=""   method="POST">
          <input class="form-control " autocomplete="off" type="text" name="admin_name" placeholder="Username Eg:XYZ" required/><br>
          <input class="form-control" autocomplete="off" type="password" name="admin_passwd" placeholder="Password Eg:**********" required/><br>
          <button class="w3-red w3-button w3-wide" type="submit" name="admin_submit" id="admin_submit" value="Login" >Log in</button>
        </form>
      </div>
      <div id="Cashier" class="Hotel_role" style="display:none">
        <form action="admin_login.php" id="form_cashier_login" class=""   method="POST">
          <input class="form-control " autocomplete="off" type="text" name="cashier_name" placeholder="Username Eg:XYZ" required/><br>
          <input class="form-control" autocomplete="off" type="password" name="cashier_passwd" placeholder="Password Eg:**********" required/><br>
          <button class="w3-red w3-button w3-wide" type="submit" name="cashier_submit" id="cashier_submit" value="Login" >Log in</button>
        </form>
      </div>
      <div id="Waiter" class="Hotel_role" style="display:none">
        <form action="admin_login.php" id="form_waiter_login" class=""   method="POST">
          <select id="waiter_name" name="waiter_name" class="form-control w3-margin-bottom" required>
            <option class="w3-red" selected>Select your name</option>
              <?php                
              $waiter_sql="SELECT DISTINCT * FROM user_login WHERE role='Waiter' ORDER BY username ";
              $waiter_sql_result=mysqli_query($conn,$waiter_sql);
              while($waiter_sql_row = mysqli_fetch_array( $waiter_sql_result))
              {
                echo '<option value="'.$waiter_sql_row['username'].'">'.strtoupper($waiter_sql_row['username']).'</option>';
              }
              ?>              
          </select>
          <input class="form-control" autocomplete="off" type="password" name="waiter_passwd" placeholder="Password Eg:**********" required/><br>
          <button class="w3-red w3-button w3-wide" type="submit" name="waiter_submit" id="waiter_submit" value="Login" >Log in</button>
        </form>
      </div>
      <div id="Customer" class="Hotel_role" style="display:none">
        <form action="admin_login.php" id="form_customer_login" class="" method="POST">
          <select id="table_id" name="table_id" class="form-control w3-margin-bottom" required>
            <option class="w3-red" selected>Select Table</option>
              <?php                
              $customer_sql="SELECT DISTINCT * FROM hotel_tables ORDER BY table_name";
              $customer_sql_result=mysqli_query($conn,$customer_sql);
              while($customer_sql_row = mysqli_fetch_array( $customer_sql_result))
              {
                echo '<option value="'.$customer_sql_row['table_id'].'">Table T'.strtoupper($customer_sql_row['table_name']).'</option>';
              }
              ?>              
          </select>          
          <input class="form-control" autocomplete="off" type="password" name="customer_passwd" placeholder="Password Eg:**********" required/><br>
          <button class="w3-red w3-button w3-wide" type="submit" name="customer_submit" id="customer_submit" value="Login" >Log in</button>
        </form>
      </div>


    </div>

  </div>
  <div class="col-lg-4 w3-hide-small"></div>
<script>
// SELECT BOX DEPENDENCY CODE
$(document).ready(function()
{
 $(function() {
  $('#role').change(function(){
    $('.Hotel_role').hide();
    $('#' + $(this).val()).show();
  });
});
});
</script>
</body>
</html>
