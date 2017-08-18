<?php 

if(isset($_SESSION["cart"])){
    $item_total = 0;

if(empty($_SESSION['cart']))
{
	$count=0;
}
else {
	$count=count($_SESSION['cart']);
	
	echo '

	<div class="dropdown w3-red">	
		<a class="btn w3-medium dropdown-toggle" data-toggle="dropdown">
			<span class="w3-badge cartItem_count w3-small w3-black">'.$count.'</span>
			<i class="fa fa-shopping-cart w3-xxlarge fa-fw"></i> <b>Cart items</b></a>
			<ul class="dropdown-menu dropdown-menu-right w3-card-4 w3-text-black" style="right:0;width: 250px;">';

				foreach ($_SESSION["cart"] as $item){
					echo '
					<li>
					<a class="btn w3-right w3-text-red" href="customer_home.php?action=remove&item_id='.$item["item_id"].'" style="padding:0"><span class="fa fa-remove"></span></a>
					<div class="w3-col l12" style="margin-bottom: 5px;padding:5px">
							<div class="w3-col l4 w3-col s4">
								<img src="images/onepage_restaurant.jpg" width="auto" height="50px" alt="Item" style="width:100%">
							</div>
							<div class="w3-col l8 w3-col s8 " style="padding:0">
								<div class="w3-col l12 w3-col s12">'.$item["item_name"].'</div>
								<div class="w3-col l12 w3-col s12">Qty: '.$item["quantity"].'</div>
								<div class="w3-col l12 w3-col s12">Cost: Rs.'.$item["item_price"].'</div>
							</div>
							</div>
					</li>';
					$item_total += ($item["item_price"]*$item["quantity"]);
				}
				echo '
			     <li class="txt-heading">Shopping Cart <a id="btnEmpty" href="customer_home.php?action=empty">Empty Cart</a></li>
			     </ul>
				<a><strong>Total:</strong>Rs.'.$item_total.'</a>
			</div>';	


		}

}
		?>
