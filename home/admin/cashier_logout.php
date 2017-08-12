<?php

session_start();
session_unset($_SESSION['cashier']);
echo "<script>window.location='../index.php'</script>";
?>