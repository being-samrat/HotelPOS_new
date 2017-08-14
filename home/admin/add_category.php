<?php

include("../db_conn/conn.php");
$new_category=$_POST['new_category'];

$newcat_sql="INSERT INTO menu_category(cat_name) VALUES('".$new_category."')";

if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
  echo "<script>alert('".$new_category." Category added');
  window.location.href='admin_manageSettings.php';
  </script>";
}
else
{
    echo "Insertion Failed ".mysqli_error($conn);
}
mysqli_close($conn);
?>