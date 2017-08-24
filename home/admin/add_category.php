<?php
error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
$new_category=$_POST['new_category'];

$newcat_sql="INSERT INTO menu_category(cat_name) VALUES('".$new_category."')";

if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
  echo "<script>
  window.location.href='admin_manageSettings.php';
  </script>";
}
else
{
    echo "Insertion Failed ".mysqli_error($conn);
}
mysqli_close($conn);
?>