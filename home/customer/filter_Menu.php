  <?php
  session_start();

  include_once("../db_conn/conn.php");
//if(isset)
  ?>
  <!-- Header -->
  <header class="w3-container " >
    <h5><b><i class="fa fa-filter"></i> Filter Menu Items</b></h5>
  </header>

  <!-- !PAGE CONTENT! -->

  <div class="w3-row-padding w3-margin-bottom" id="searched">

    <?php 

    $relevance=$_POST['relevance'];
    $sortBy=$_POST['sortBy'];
    $category=$_POST['category'];

    $table_ID=$_SESSION['customer_table'];
    $get_tno="SELECT * FROM hotel_tables WHERE table_id='".$table_ID."'";
    $get_tno_res=mysqli_query($conn,$get_tno);
    $status=0;
    while($row = mysqli_fetch_array( $get_tno_res))
    { 
      $status=$row['status']; //get table Ac or non AC from table_id.............................
    }

    if($category=='all'){
      switch ($relevance) {
        case 'newest':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY item_id DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY item_id ASC";            
        }
        break;

        case 'price':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY item_price DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY item_price ASC";            
        }
        break;

        case 'popularity':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY ordered_count DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1' ORDER BY ordered_count ASC";            
        }
        break;

        default:
        $fetch_customer_menu_sql="SELECT * FROM menu_items WHERE status='$status' AND visible='1'";            
        break;
      }
    }
    else{
      switch ($relevance) {
        case 'newest':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.item_id DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.item_id ASC";            
        }
        break;

        case 'price':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.item_price DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.item_price ASC";            
        }
        break;

        case 'popularity':
        if($sortBy=='hightolow'){
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.ordered_count DESC";
        }
        else{
          $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status' ORDER BY mi.ordered_count ASC";            
        }
        break;

        default:
        $fetch_customer_menu_sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name='$category' AND mi.visible='1' AND mi.status='$status'";            
        break;
      }
    }
    

    $fetch_customer_menu_result=mysqli_query($conn,$fetch_customer_menu_sql);
    $item_ID="0";

    while($row = mysqli_fetch_array( $fetch_customer_menu_result))
    {
      $item_ID=$row['item_id'];
      $item_NAME=$row['item_name'];
      $item_PRICE=$row['item_price'];

      echo '<div class="w3-quarter w3-margin-bottom">
      <div class="w3-white" style="height: 380px;padding: 0spx;font-family:Segoe UI;letter-spacing:1px;">
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
