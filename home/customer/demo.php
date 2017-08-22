<?php
session_start();
include_once("../db_conn/conn.php");
?>
 <!DOCTYPE html>
<html>
<head>
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
	</style>


           <script type="text/javascript">

    $(document).ready(function(){

      $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          total_cart_items:"totalitems"
        },
        success:function(response) {
          document.getElementById("total_items").value=response;
        }
      });

    });

    function cart(id)
    {
	  var ele=document.getElementById(id);
	  var img_src=ele.getElementsByTagName("img")[0].src;
	  var name=document.getElementById(id+"_name").value;
	  var price=document.getElementById(id+"_price").value;
	
	  $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          item_src:img_src,
          item_name:name,
          item_price:price
        },
        success:function(response) {
          document.getElementById("total_items").value=response;
        }
      });
	
    }

    function show_cart()
    {
      $.ajax({
      type:'post',
      url:'store_items.php',
      data:{
        showcart:"cart"
      },
      success:function(response) {
        document.getElementById("mycart").innerHTML=response;
        $("#mycart").slideToggle();
      }
     });

    }
	
</script>
  
</head>
<body style="background-color: #E4E4E4">
	<span class="w3-margin w3-padding-small w3-grey"><a href="customer_logout.php">Logout</a></span>


           <br />  

<p id="cart_button" onclick="show_cart();">
  <img src="cart_icon.png">
  <input type="button" id="total_items" value="">
</p>

<div id="mycart">
</div>

<h1>Simple Add To Cart System Using jQuery,Ajax And PHP</h1>

<div id="item_div">
<?php 
$join_tno="SELECT * FROM menu_items ";
							$join_tno_res=mysqli_query($conn,$join_tno);

							while($row = mysqli_fetch_array( $join_tno_res))
							{ 
								echo '<div class="items" id="'.$row['item_id'].'">
    <img src="product1.jpg">
    <input type="button" value="Add To CART" onclick="cart(\''.$row['item_id'].'\')">
    <p>'.$row['item_name'].'</p>
    <p>Price - $'.$row['item_price'].'</p>
    <input type="hidden" id="'.$row['item_id'].'_name" value="'.$row['item_name'].'">
    <input type="hidden" id="'.$row['item_id'].'_price" value="$'.$row['item_price'].'">
  </div>';
							}
?>
  


</div>
      </body>  
 </html>