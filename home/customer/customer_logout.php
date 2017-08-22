<?php

session_start();
session_unset($_SESSION['customer_table']);
session_unset($_SESSION['cart']);
echo "<script>window.location='../index.php'</script>";
?>