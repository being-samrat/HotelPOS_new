<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
if(!isset($_SESSION['customer_table']))
{
  $_SESSION['customer_table']='';
  header("location:../index.php");
}
?>
<?php

include_once("../db_conn/conn.php");
//if(isset)
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
  <link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>
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
      width: 318px;
      background: rgba(255,255,255,.5);
    }
    .cartItem_count{
      position:absolute;
      margin:-2px 0 0 15px;
      padding-left:5px;
      padding-right:5px;
    }
    .more_style{
      position:absolute;
      margin:25px 50px 0 -65px;
      padding-left:5px;
      padding-right:5px;
    }
  </style>
  
</head>
<body style="font-family:Segoe UI;letter-spacing:1px;">
  <div class="container-fluid w3-red">

   <div class="w3-col l2">
     <span class="w3-xlarge w3-hide-small">HOTEL POS</span>
     <?php 
     $table_ID=$_SESSION['customer_table'];
     $get_tno="SELECT * FROM hotel_tables WHERE table_id='".$table_ID."'";
     $get_tno_res=mysqli_query($conn,$get_tno);
     $table_NO="";
     $status=0;
     while($row = mysqli_fetch_array( $get_tno_res))
     { 
      $table_NO=$row['table_name']; //get table name from table_id.............................
      $status=$row['status']; //get table status from table_id.............................
    }
    ?>
  </div> 
  <div class="w3-col l6 s12 w3-margin-top" >
    <div class="form-group w3-card w3-light-grey">        
      <div class="input-group">          
        <input class="form-control" type="text" autocomplete="off" name="customer_searchBox" id="customer_searchBox" placeholder="search menu items here....">
        <span class="input-group-btn">
          <button class="btn fa fa-search w3-large w3-text-red"></button>
        </span>          
      </div>
    </div>      
</div>
<div class="w3-col l4 s12">
 <div class="w3-col l6 s6 text-right">
  <a href="customer_viewOrder.php" class="btn w3-medium" id="customer_viewOrder">Hello Customer,<br><b>View Your Order</b></a>
</div> 
<div class="w3-col l6 s6 text-left" id="cart">    
  <?php include("cart_items.php"); ?>
</div>     
</div> 


  <div class="w3-col l12">
  <div class="col-lg-2 col-sm-1"></div>
  <div class="w3-col l7 s10 w3-small">
    <form id="filterMenu_form" style="margin-bottom:10px" method="POST" action="filter_Menu.php">
     <label class="w3-label w3-text-white ">Category :
        <select name="category" class="w3-text-black w3-card-2">
          <option value="all">ALL</option>
          <?php                
          $cat_sql="SELECT DISTINCT * FROM menu_category ORDER BY cat_name ";
          $cat_sql_result=mysqli_query($conn,$cat_sql);
          while($cat_sql_row = mysqli_fetch_array( $cat_sql_result))
          {
            echo '<option value="'.$cat_sql_row['cat_name'].'">'.strtoupper($cat_sql_row['cat_name']).'</option>';
          }
          ?>  
        </select>
      </label>  &nbsp;&nbsp;
      <label class="w3-label w3-text-white">Relevance :
        <select name="relevance" class="w3-text-black w3-card-2">
          <option value="newest">By Newest</option>
          <option value="price">By Price</option>
          <option value="popularity">By Popularity</option>
        </select>
      </label> &nbsp;&nbsp;
      <label class="w3-label w3-text-white">Sort By:
        <select name="sortBy" class="w3-text-black w3-card-2">
          <option value="hightolow">Highest to Lowest </option>
          <option value="lowtohigh">Lowest to Highest</option>
        </select> 
      </label> &nbsp;&nbsp;
 <a class="btn w3-small w3-card-4 w3-padding-tiny" id="filter_Menu">Go <i class="fa fa-filter"></i></a>

    </form>

  </div>
  <div class="col-lg-3 col-sm-1">
    <a href="customer_logout.php" id="customer_logout" name="customer_logout" class="btn w3-grey w3-text-white w3-padding-small w3-right fa fa-sign-out w3-small"> Logout</a>
  </div>
</div>
</div>

<div class="w3-main" style="margin-top: 0" id="customer_pageView">
  <!-- Header -->
  <header class="w3-container " >
    <h5><b><i class="fa fa-edit"></i> Order Menu Items</b></h5>
  </header>

  <!-- !PAGE CONTENT! -->

  <div class="w3-row-padding w3-margin-bottom" id="searched">

    <?php  
    $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY item_id DESC";
    $fetch_customer_menu_result=mysqli_query($conn,$fetch_customer_menu_sql);
    $item_ID="0";

    while($row = mysqli_fetch_array( $fetch_customer_menu_result))
    {
      $item_ID=$row['item_id'];
      $item_NAME=$row['item_name'];
      $item_PRICE=$row['item_price'];

      echo '<div class="w3-quarter w3-margin-bottom">
      <div class="w3-white" style="height: 380px;padding: 0px;font-family:Segoe UI;letter-spacing:1px;">
        <div class="w3-col l12" >
          <div class="w3-white w3-opacity img_opaque"></div>
          <img src="images/onepage_restaurant.jpg" height="200px" width="100%">
        </div>
        <div class="w3-container w3-col s12 w3-large" style="font-weight: bolder;padding:5px 2px 0 10px">
          <span>'.$row['item_name'].'</span>
        </div>        
        <div class="w3-col s12 w3-col s12 w3-small" style="padding:5px 2px 0 10px">
          <div class="w3-col s12 w3-col s12" data-toggle="toggle" id="more_'.$row['item_id'].'" style="max-height: 40px;overflow-y: hidden;margin-bottom:0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo onsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </div>
          <a class="btn w3-text-red w3-right w3-margin-right more_style" style="font-weight:bold" onClick="more('.$row['item_id'].')">..more</a>   
        </div>  
        <div class="w3-col l12 w3-col s12 w3-margin-top" >               
          <div class="w3-col l6 w3-col s6" style="padding:5px 2px 0 10px">
            <span class="w3-left">Quantity : <input class=" " type="number" placeholder="count" id="quantity_'.$row['item_id'].'" value="1" style="width:35px"></span>
          </div>          
          <div class="w3-col l6 w3-col s6" style="padding:0px 10px 0 2px">                 
            <span class="w3-right w3-xlarge"><b>'.$row['item_price'].'<i class="fa fa-inr"></i></b></span><br>
            <span class="w3-right w3-tiny">(each)</span>

            <input type="hidden" id="name_'.$row['item_id'].'" value="'.$row['item_name'].'">
            <input type="hidden" id="price_'.$row['item_id'].'" value="'.$row['item_price'].'">
          </div>  
        </div>   
        <div class="w3-col l12 w3-center" style="margin-top: 10px">
          <button type="button" class="w3-red w3-button form-control" onclick="addCart(\''.$item_ID.'\')" >Add To Basket</button>
        </div>
      </div>
    </div>';
  }

  ?>



</div>
</div>
<script type="text/javascript">

 function addCart(id)
 {
  var name=document.getElementById("name_"+id).value;
  var quantity=document.getElementById("quantity_"+id).value;
  var price=document.getElementById("price_"+id).value; 
  $.confirm({
    title: 'Add to Basket!',
    content: 'Want to add only '+quantity+' '+name+'!',
    buttons: {
      confirm: function () {
       $.ajax({
        type:'post',
        url:'addCart.php',
        data:{
          item_id:id,
          item_name:name,
          item_quantity:quantity,
          item_price:price
        },
        success:function(response) {
          location.reload();
          //$.alert(response);
        }
      });
     },
     cancel: function () {

     }
   }
 });
}

function delCart(id)
{

 $.ajax({
  type:'post',
  url:'addCart.php',
  data:{
    delete_item_id:id  },
    success:function(response) {
      location.reload();
    }
  });
}

function more(id)
{
  $("#menu_"+id+"").slideToggle();
}
</script>

<!--   script to load view order page on div
-->
<script>
  $(function() {
    $("#customer_viewOrder").click(function(e) {
        e.preventDefault(); //so the browser doesn't follow the link

        $("#customer_pageView").load(this.href, function() {
            //execute here after load completed
          });
      });
  });
</script>

<!-- script to filter the page with menu items..........................................
-->
<script>
  $("#filter_Menu").click( function() {
    $.post( $("#filterMenu_form").attr("action"), 
      $("#filterMenu_form :input").serializeArray(), 
      function(info){ 
        $("#customer_pageView").html(info);

      });
  });

  $("#filterMenu_form").submit( function() {
    return false; 
  });

</script>


<!-- script for searchbox...................................................
 -->
<script>  
  $(document).ready(function(){  
    $('#customer_searchBox').keyup(function(){  
      var query = $(this).val();  
      var data = {
        query:query
      };
      if(query != '')  
      {  
        $.ajax({  
          url:"customer_searchBox.php",  
          method:"POST",  
          cache:false,
          data:data,  
          success:function(data)  
          {  
            //$('#search_foodList').fadeIn();  
            $('#searched').html(data);  
          }  
        });  
      }  
    });  
  
  }); 

</script> 

 </body>
</html>
