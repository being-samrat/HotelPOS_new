<?php

session_start();
if(!isset($_SESSION['custom']))
{
	header("Location: index.php");
}

include_once("../db_conn/conn.php");
?>
		<?php

if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$getid_sql="SELECT * FROM menu_items WHERE item_id='" . $_GET["item_id"] . "'";
        $getid_res=mysqli_query($conn,$getid_sql);
        
        while($row = mysqli_fetch_array( $getid_res))
        {	$productByCode[]=$row;
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

</head>
<body style="background-color: #E4E4E4">
	<span class="w3-margin w3-padding-small w3-grey"><a href="customer_logout.php">Logout</a></span>

	<!-- Top container -->
	<div class="w3-main " style="margin-top:55px;">
		<div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>


<div id="shopping-cart">
<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="demo.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart"])){
    $item_total = 0;
?>	
<table cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;"><strong>Name</strong></th>
<th style="text-align:left;"><strong>ID</strong></th>
<th style="text-align:right;"><strong>Quantity</strong></th>
<th style="text-align:right;"><strong>Price</strong></th>
<th style="text-align:center;"><strong>Action</strong></th>
</tr>	
<?php		
    foreach ($_SESSION["cart"] as $item){
		?>
				<tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["item_name"]; ?></strong></td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["item_id"]; ?></td>
				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "$".$item["item_price"]; ?></td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="demo.php?action=remove&item_id=<?php echo $item["item_id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
				</tr>
				<?php
        $item_total += ($item["item_price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?></td>
</tr>
</tbody>
</table>		
  <?php
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$fetch_tables="SELECT * FROM menu_items";
        $fetch_tables_result=mysqli_query($conn,$fetch_tables);
        
        while($row = mysqli_fetch_array( $fetch_tables_result))
        {
        	$product_array[]=$row;
        }
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="demo.php?action=add&item_id=<?php echo $product_array[$key]["item_id"]; ?>">
			<div><strong><?php echo $product_array[$key]["item_name"]; ?></strong></div>
			<div class="product-price"><?php echo "$".$product_array[$key]["item_price"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>

	<!--  -->
	</body>
	</html>
