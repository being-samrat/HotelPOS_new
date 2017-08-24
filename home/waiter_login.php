<?php
session_start();

include_once("db_conn/conn.php");

$success="";

// script to change waiter password
if(isset($_POST['waiter_login_submit']))
{ 
  $waiter_list=$_POST['waiter_list'];
  $waiter_passwd=$_POST['waiter_passwd']; 

  $waiterLogin_sql="SELECT * FROM user_login WHERE username='$waiter_list' AND password='$waiter_passwd' AND role='Waiter'";
  $waiterLogin_result=mysqli_query($conn,$waiterLogin_sql);

// Mysql_num_row is counting table row
  $count=mysqli_num_rows($waiterLogin_result);
  if ($count == 1) {
    $_SESSION['waiter_name']=$waiter_list;
    $hide_waiter="";

    $err='<div class="alert alert-success w3-margin-bottom w3-col l4">
    <strong>Login Success!</strong> 
  </div>
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 900);
  </script>';
  echo "<script>window.location='index.php'</script>";

}
else{
 $hide_waiter="w3-hide";
 $err='<div class="alert alert-danger w3-margin-bottom w3-col l4">
 <strong>Login Failed!</strong> 
</div>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 900);
</script>'; 
echo "<script>window.location='index.php'</script>";

}
}
?>