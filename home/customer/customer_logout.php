<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
session_unset($_SESSION['customer_table']);
session_unset($_SESSION['cart']);
echo "<script>window.location='../index.php'</script>";
?>