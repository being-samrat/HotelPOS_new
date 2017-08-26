<?php 
error_reporting(E_ERROR | E_PARSE);


$item_total = 0;
$count=0;
//unset($_SESSION['cart']);
$json=json_decode($_SESSION['cart'],true);


foreach ($json as $item){
	$count+= 1;//count items in cart
}

	echo '<div class="dropdown w3-red ">	
	<a class="btn w3-medium dropdown-toggle w3-margin-top" data-toggle="dropdown">
		<span class="w3-badge cartItem_count w3-small w3-black">'.$count.'</span>
		<i class="fa fa-shopping-basket w3-xlarge fa-fw"></i> <br><b>Basket items</b></a>
		<ul class="dropdown-menu dropdown-menu-right w3-card-4 w3-padding-medium w3-text-black" style="right:0;width: 250px;">';
			if(!isset($_SESSION['cart']))
			{
				echo "<div class='w3-center'><span class='w3-text-red w3-margin'><strong>Your Basket Is Empty </strong></span></div>";
			}
			else {				
				foreach ($json as $item){
					echo '
					<li class="">
						<a class="btn w3-right w3-text-red" onclick="delCart(\''.$item["item_id"].'\')" style="padding:0"><span class="fa fa-remove"></span></a>
						<div class="w3-col l12 w3-border-bottom" style="font-family:Segoe UI;letter-spacing:1px;padding:0;margin:0">						
							<div class="w3-col l4 w3-col s4 " style="padding:5px">
								<img src="images/onepage_restaurant.jpg" width="auto" height="100%" alt="Item" style="width:100%">
							</div>
							<div class="w3-col l8 w3-col s8 " style="padding:5px">
								<div class="w3-col l12 w3-col s12">'.$item["item_name"].'</div>
								<div class="w3-col l12 w3-col s12">Qty: '.$item["quantity"].'</div>
								<div class="w3-col l12 w3-col s12">Cost: '.$item["item_price"].' <i class="fa fa-inr"></i></div>
							</div>
						</div>
					</li>';
					$item_total += ($item["item_price"]*$item["quantity"]);
				}
				echo '
				
				<li class="txt-heading w3-center">
					<a class=""><strong>Total Cost:</strong> '.$item_total.' <i class="fa fa-inr"></i></a>
					<a class="w3-button w3-green w3-wide w3-medium " id="checkout_btn"><i class="w3-xlarge fa fa-check-circle-o"></i> Finalize Order</a>
				</li>
			</ul>';
			

		}
		echo '</div>';

		?>

		<!-- 	Script to add items in kot tabke and order table..........................
-->	
<script>
	$("#checkout_btn").click( function() {
		var cart_items=<?php echo $_SESSION['cart']; ?>;
		var table_id=<?php echo $_SESSION['customer_table']; ?>;
		// console.log(name);
  // 		var quantity=document.getElementById("quantity_"+id).value;
       $.ajax({
        type:'post',
        url:'Cart_order.php',
        data:{
          cart_items:cart_items,  
          table_id:table_id 
      },
        success:function(response) {
          //location.reload();
         	$.alert(response);
         	setTimeout("window.location='customer_home.php'",3000);
        }
      });
	});

	
</script>
