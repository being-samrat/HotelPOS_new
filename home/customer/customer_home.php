<?php
// error_reporting(E_ERROR | E_PARSE);
// session_start();
// if(!isset($_SESSION['admin_passwd']))
// {
//   header("location:../index.php");
// }
?>
<?php
session_start();

include_once("../db_conn/conn.php")
?>
<?php

if(!empty($_GET["action"])) {
  switch($_GET["action"]) {
    case "add":
    if(!empty($_POST["quantity"])) {
      $getid_sql="SELECT * FROM menu_items WHERE item_id='" . $_GET["item_id"] . "'";
      $getid_res=mysqli_query($conn,$getid_sql);

      while($row = mysqli_fetch_array( $getid_res))
        { $productByCode[]=$row;
        }
        $itemArray = array($productByCode[0]["item_id"]=>array('item_name'=>$productByCode[0]["item_name"], 'item_id'=>$productByCode[0]["item_id"], 'quantity'=>$_POST["quantity"], 'item_price'=>$productByCode[0]["item_price"]));

        if(!empty($_SESSION["cart"])) {
          if(in_array($productByCode[0]["item_id"],array_keys($_SESSION["cart"]))) {
            foreach($_SESSION["cart"] as $k => $v) {
              if($productByCode[0]["item_id"] == $k) {
                if(empty($_SESSION["cart"][$k]["quantity"])) {
                  $_SESSION["cart"][$k]["quantity"] = 0;
                }
                $_SESSION["cart"][$k]["quantity"] += $_POST["quantity"];
              }
            }
          } else {
            $_SESSION["cart"] = array_merge($_SESSION["cart"],$itemArray);
          }
        } else {
          $_SESSION["cart"] = $itemArray;
        }
      }
      break;
      case "remove":
      if(!empty($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $k => $v) {
          if($_GET["item_id"] == $k)
            unset($_SESSION["cart"][$k]);       
          if(empty($_SESSION["cart"]))
            unset($_SESSION["cart"]);
        }
      }
      break;
      case "empty":
      unset($_SESSION["cart"]);
      break;  
    }
  }
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Customer Order Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HOTEL POS</title>
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/w3.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
    <style type="text/css">
      .table_view{
        background-image: url(admin/adminImg/empty.png);
        background-size: 40px;
        background-repeat: no-repeat;
        background-position: left;
        background-origin: content-box;
        padding-top:15px;
      }
      .img_opaque{
        height: 80px;
        margin-top: 120px;
        position:absolute;
        width: 150px;
        background: rgba(255,255,255,.5);
      }
      .cartItem_count{
        position:absolute;
        margin:-2px 0 0 30px;
        padding-left:5px;
        padding-right:5px;
      }
    </style>
  </head>
  <body style="background-color: ">
    <div class="container-fluid w3-red">
     <div class="w3-col l2">
       <span class="w3-xlarge w3-hide-small">HOTEL POS</span>
     </div> 
     <div class="w3-col l6 s12 w3-margin-top" >
       <form method = "POST">
        <div class="form-group ">        
          <div class="input-group">          
            <input class="form-control" type="text" autocomplete="off" name="customer_searchBox" placeholder="search menu items here....">
            <span class="input-group-btn">
              <select name="menu_category" class="btn btn-default w3-card">
                <option value="percentage" selected>All</option>
                <option value="percentage">INDIAN</option>
                <option value="percentage">INDIAN</option>
              </select>
            </span>          
          </div>
        </div>      
      </form>
    </div>
    <div class="w3-col l4 s12">
     <div class="w3-col l6 s6 text-right">
      <a href="admin_index.php" class="btn w3-medium" >Hello Customer,<br><b>View Your Order</b></a>
    </div>
    <?php print_r($_SESSION['cart']); ?> 
    <div class="w3-col l6 s6 text-left"> 

     <?php include_once("cart_items.php"); ?>
   </div>     
 </div> 

</div>

<div class="w3-main" style="margin-top: 0">
  <!-- Header -->
  <header class="w3-container " >
    <h5><b><i class="fa fa-edit"></i> Order Menu Items</b></h5>
  </header>

  <!-- !PAGE CONTENT! -->

  <div class="w3-row-padding w3-margin-bottom">

    <?php  
    $fetch_customer_menu_sql="SELECT * FROM menu_items ORDER BY item_id DESC";
    $fetch_customer_menu_result=mysqli_query($conn,$fetch_customer_menu_sql);      

    while($row = mysqli_fetch_array( $fetch_customer_menu_result))
      {        $product_array[]=$row; } 

    if (!empty($product_array)) { 
      foreach($product_array as $key=>$value){

        echo '<div class="w3-quarter w3-margin-bottom">
        <div class="w3-white" style="height: 410px;padding: 5px">
          <form method="POST" action="customer_home.php?action=add&item_id='.$product_array[$key]["item_id"].'">
            <div class="w3-col l12" >
              <div class="w3-white w3-opacity img_opaque"></div>
              <img src="images/onepage_restaurant.jpg" height="200px" width="100%">
            </div>
            <div class="w3-container w3-col s12 w3-xlarge" style="font-weight: bolder;padding-left: 0px">
              <span>'.$product_array[$key]["item_name"].'</span>
            </div>        
            <div class="w3-col s12 w3-col s12" style="">
              <div class="w3-col s12 w3-col s12" style="max-height: 40px;overflow-y: hidden;">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </div>
              <span class="w3-text-red w3-right w3-margin-right" style="margin-bottom: 0">...more</span>   
            </div> 

            <div class="w3-col l12 w3-col s12">
              <hr style="margin: 0">     
              <div class="w3-col l4 w3-col s4">
                <span class="w3-left"><u>Qty: </u></span> <br>
                <input class="form-control w3-left" type="number" placeholder="count" name="quantity" value="1">
              </div>          
              <div class="w3-col l8 w3-col s8">
                <span class="w3-right"><u>Rate (each):</u></span><br>       
                <span class="w3-right w3-large"><b>Rs. '.$product_array[$key]["item_price"].'</b></span>                        
              </div>  
            </div>   
            <div class="w3-col l12 w3-center" style="margin-top: 5px">
              <button type="submit" class="w3-red btn form-control">Add To Cart</button>
            </div>
          </form>
        </div>
      </div>';
    }
  }
  ?>



</div>
</div>


</body>
</html>
