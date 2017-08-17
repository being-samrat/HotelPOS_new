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
<body style="background-color: #E4E4E4">
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
   <div class="w3-col l6 s6 text-left">    
      <?php include("cart_items.php"); ?>
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
      {
        echo '<div class="w3-quarter w3-margin-bottom">
        <div class="w3-white" style="height: 410px;padding: 5px">
          <div class="w3-col l12" >
            <div class="w3-white w3-opacity img_opaque"></div>
            <img src="images/onepage_restaurant.jpg" height="200px" width="100%">
          </div>
          <div class="w3-container w3-col s12 w3-xlarge" style="font-weight: bolder;padding-left: 0px">
            <span>'.$row['item_name'].'</span>
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
              <input class="form-control w3-left" type="number" placeholder="count" name="food_quantity" value="1">
            </div>          
            <div class="w3-col l8 w3-col s8">
              <span class="w3-right"><u>Rate (each):</u></span><br>       
              <span class="w3-right w3-large"><b>Rs. '.$row['item_price'].'</b></span>                        
            </div>  
          </div>   
          <div class="w3-col l12 w3-center" style="margin-top: 5px">
            <a type="submit" class="w3-red btn form-control" href="addCart.php?item_id='.$row['item_id'].'&item_name='.$row['item_name'].'">Add To Cart</a>
          </div>
        </div>
      </div>';
      }

        ?>

      

    </div>
  </div>

 
</body>
</html>
