<?php
//error_reporting(E_ERROR | E_PARSE);

session_start();
session_unset($_SESSION['waiter']);
echo "<script>window.location='../index.php'</script>";
?>