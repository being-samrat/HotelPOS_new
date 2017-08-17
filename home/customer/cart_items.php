<?php 

if(!isset($_SESSION['cart']))
{
	$count=0;
}
else {
	$count=count($_SESSION['cart'])-1;
	
	echo '
	<div class="w3-dropdown-hover w3-red">	
	<a href="" class="btn w3-medium">
		<span class="w3-badge cartItem_count w3-small w3-black">'.$count.'</span>
		<i class="fa fa-shopping-cart w3-xxlarge fa-fw"></i> <b>Cart items</b></a>
		<div class="w3-dropdown-content w3-bar-block w3-border" style="right:0;width: 250px">';

		for($i=1;$i<$count;$i++)
		{
			echo '<div class="w3-col l12 w3-border" style="margin-bottom: 5px;padding:5px">
				<div class="w3-col l4 w3-col s4">
					<img src="images/onepage_restaurant.jpg" width="auto" height="50px" alt="Item" style="width:100%">
				</div>
				<div class="w3-col l8 w3-col s8 w3-border" style="padding:0">
					<div class="w3-col l12 w3-col s12 w3-border">'.$_SESSION['cart'][$i].'</div>
					<div class="w3-col l12 w3-col s12 w3-border">Qty: 3</div>
					<div class="w3-col l12 w3-col s12 w3-border">Cost: Rs.220</div>
				</div>
			</div>';
		}

		echo '</div>
	</div>';	
	

}


?>
