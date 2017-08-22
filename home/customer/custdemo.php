
<?php
session_start();

include_once("../db_conn/conn.php");


 // $table_id=$_POST['Customer_table_id'];

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
        width: 308px;
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
       <span class="w3-xlarge w3-hide-small">HOTEL POS <?php echo $table_id; ?></span>
     </div> 
     <div class="w3-col l6 s12 w3-margin-top" >
       <form method = "POST">
        <div class="form-group ">        
          <div class="input-group"> 
          <span class="input-group-btn">
              <select name="menu_category" class="btn btn-default w3-medium">
                <option selected>ALL</option>
               <?php                
              $cat_sql="SELECT DISTINCT * FROM menu_category ORDER BY cat_name ";
              $cat_sql_result=mysqli_query($conn,$cat_sql);

              while($cat_sql_row = mysqli_fetch_array( $cat_sql_result))
              {
                echo '<option value="'.$cat_sql_row['cat_name'].'">'.strtoupper($cat_sql_row['cat_name']).'</option>';
              }
              ?>  
              </select>
            </span>
            
            <input class="form-control" type="text" autocomplete="off" name="customer_searchBox" placeholder="search menu items here....">                       
      
          <span class="input-group-btn">
            <a class="btn fa fa-search w3-large w3-padding-medium w3-red" type="submit"></a>
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
     <?php include_once("cart_items.php"); ?>
   </div>   
   <?php print_r($_SESSION['name']); ?>  
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

    while($row = mysqli_fetch_assoc( $fetch_customer_menu_result))
      {        

        echo '<div class="w3-quarter w3-margin-bottom" id="'.$row['item_id'].'">
        <div class="w3-white" style="height: 410px;padding: 5px">
            <div class="w3-col l12" >
              <div class="img_opaque" ></div>
              <img src="../admin/'.$row["item_image"].'" id="'.$row["item_id"].'_image" height="200px" width="100%">
            </div>
            <div class="w3-container w3-col s12 w3-xlarge" style="font-weight: bolder;padding-left: 0px">
              <span>'.$row["item_name"].'</span>
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
              <span class="w3-text-red w3-right w3-margin-right" style="margin-bottom: 0">more</span>   
            </div> 

            <div class="w3-col l12 w3-col s12">
              <hr style="margin: 0">     
              <div class="w3-col l4 w3-col s4">
                <span class="w3-left"><u>Qty: </u></span> <br>
                <input class="form-control w3-left" type="number" placeholder="count" id="'.$row["item_id"].'_quantity" name="'.$row["item_id"].'_quantity" value="1">
              </div>          
              <div class="w3-col l8 w3-col s8">
                <span class="w3-right"><u>Rate (each):</u></span><br>       
                <span class="w3-right w3-large"><b><i class="fa fa-inr"></i> '.$row["item_price"].'</b></span> 
                <input type="hidden" id="'.$row['item_id'].'_name" value="'.$row['item_name'].'">
                <input type="hidden" id="'.$row['item_id'].'_price" value="'.$row['item_price'].'">                       
              </div>  
            </div>   
            <div class="w3-col l12 w3-center" style="margin-top: 5px">
              <button type="submit" class="w3-red btn form-control"  onclick="cart(\''.$row['item_id'].'\')">Add To Cart</button>
            </div>
        </div>
      </div>';
    }
  
  ?>
</div>
</div>

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
    var img_src=document.getElementById(id+"_image").src;
    var name=document.getElementById(id+"_name").value;
    var price=document.getElementById(id+"_price").value;
    var quantity=document.getElementById(id+"_quantity").value;
  
    $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          item_src:img_src,
          item_name:name,
          item_price:price,
          item_quantity:quantity
        },
        success:function(response) {
          document.getElementById("cart_count").innerHTML=response;
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
        document.getElementById("cart_items").innerHTML=response;
        //$("#mycart").slideToggle();
      }
     });

    }
  
</script>
</body>
</html>
