<?php 	
error_reporting(E_ERROR | E_PARSE);
session_start();
include('../db_conn/conn.php');
if($_POST['id'])
{
	$id=$_POST['id'];
	$item_info="Description Not Available...";
	$sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name = '$id' AND mi.visible='1'";
	$result = mysqli_query($conn,$sql);
//echo '<select class="form-control w3-margin"  style="width: 40%" >';
	
	echo '<table class="table table-bordered table-striped w3-card-2" >
	<thead>
		<tr>
			<th>Item Image</th>
			<th>Item Name</th>
			<th>Item Info</th>
			<th>Rate</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>';
		while($row = mysqli_fetch_array($result)) {
			if ($row['item_info']!='') {
				$item_info=$row['item_info'];
			}
			
			echo '

			<tr>
				<td><img src="'.$row['item_image'].'" width="50px" height="50px" name="edit_menu_image"></td>
				<td>'.$row['item_name'].'</td>
				<td>'.$row['item_info'].'</td>
				<td>'.$row['item_price'].' <i class="fa fa-inr"></i></td>
				<td>
					<a class="btn w3-medium" title="Update MenuItem" data-toggle="modal" data-target="#updateMenu_'.$row['item_id'].'" style="padding:0"><i class="fa fa-edit"></i></a>
					<a class="btn w3-medium" title="Delete MenuItem" href="disable_item.php?item_id='.$row['item_id'].'" style="padding:0"><i class="fa fa-trash"></i></a>


					<!-- Modal -->
					<div id="updateMenu_'.$row['item_id'].'" class="modal fade " role="dialog">
						<div class="modal-dialog ">
							<!-- Modal content-->
							<div class="modal-content col-lg-8 col-lg-offset-2">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title w3-xxlarge w3-text-red">Update '.$row['item_name'].'</h4>
								</div>
								<div class="modal-body">
									<form method="POST" action="updateMenu.php" enctype="multipart/form-data">
										<label>Change Image: </label>
										<div class="w3-center">
										<img class="img w3-card-2 w3-margin-bottom" src="'.$row['item_image'].'" width="60px" height="60px">
										<input type="file" class="input" id="item_image" name="item_image"><span class="w3-small w3-text-red">(Image size must be < 2MB)</span>
										<input type="hidden" class="" id="item_id" name="item_id" value="'.$row['item_id'].'">
										<input type="hidden" class="" id="cat_id" name="cat_id" value="'.$row['cat_id'].'">
										<input type="hidden" class="" id="item_image_hidden" name="item_image_hidden" value="'.$row['item_image'].'">
										</div><br>
										<label>Change Name: </label>
										<input class="form-control" type="text" value="'.$row['item_name'].'" id="item_name" name="item_name"><br>

										<label>Change Price <i class="fa fa-inr"></i>: </label>
										<input class="form-control" type="text" value="'.$row['item_price'].'" id="item_price" name="item_price"><br>

										<label>Add Description: </label>
										<textarea class="form-control" rows="3" placeholder="'.$item_info.'" id="item_info" name="item_info"></textarea><br>
										<button class="btn w3-red" type="submit" name="updateMenu" id="updateMenu">Update Menu</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!--modal end-->  	
				</td>				
			</tr>

			';
			

		}
		
		echo '</tbody>
	</table>';

//echo "</select>";
	mysqli_close($conn);

}
?>




