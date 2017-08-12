
<?php

include("../db_conn/conn.php");

if(isset($_POST['newcat_submit'])){
$new_category	= $_POST['cat_id'];
//echo   $new_category;
//die();
$newcat_sql = "DELETE FROM menu_category WHERE cat_id='".$new_category."'	 ";

if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
  echo "<script>
  window.location.href='admin_manageSettings.php';
  </script>";
}
else
{
    echo "".mysqli_error($conn);
}
}
mysqli_close($conn);

?>



