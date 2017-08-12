<?php

session_start();
session_unset($_SESSION['admin_passwd']);
echo "<script>window.location='../index.php'</script>";
?>