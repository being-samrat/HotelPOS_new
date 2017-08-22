<?php
  session_start();

  if(isset($_POST['total_cart_items']))
  {
	echo count($_SESSION['name']);
	exit();
  }

  if(isset($_POST['item_src']))
  {
    $_SESSION['name'][]=$_POST['item_name'];
    $_SESSION['price'][]=$_POST['item_price'];
    $_SESSION['quantity'][]=$_POST['item_quantity'];
    $_SESSION['src'][]=$_POST['item_src'];
    echo count($_SESSION['name']);
    exit();
  }

  if(isset($_POST['showcart']))
  {
    for($i=0;$i<count($_SESSION['src']);$i++)
    {
     

      echo '<li>
                <a class="btn w3-right w3-text-red" href="customer_home.php?action=remove&item_name='.$item["item_name"].'" style="padding:0"><span class="fa fa-remove"></span></a>
                <div class="w3-col l12" style="margin-bottom: 5px;padding:5px">
                  <div class="w3-col l4 w3-col s4">
                    <img src="'.$_SESSION['src'][$i].'" width="auto" height="50px" alt="Item" style="width:100%">
                  </div>
                  <div class="w3-col l8 w3-col s8 " style="padding:0">
                    <div class="w3-col l12 w3-col s12">'.$_SESSION['name'][$i].'</div>
                    <div class="w3-col l12 w3-col s12">Qty: '.$_SESSION['quantity'][$i].'</div>
                    <div class="w3-col l12 w3-col s12">Cost: Rs.'.$_SESSION['price'][$i].'</div>
                  </div>
                </div>
              </li>';
             // $item_total += ($item["item_price"]*$item["quantity"]);
    }
    exit();	
  }
?>