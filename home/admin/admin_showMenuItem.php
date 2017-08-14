<?php 	
include('../db_conn/conn.php');
session_start();
if($_POST['id'])
{
	$id=$_POST['id'];
	$sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name = '$id' AND mi.visible='1'";
	$result = mysqli_query($conn,$sql);
//echo '<select class="form-control w3-margin"  style="width: 40%" >';
	
	echo '<table class="table table-bordered table-striped w3-card-2" >
	<thead>
		<tr>
			<th>Item Name</th>
			<th>Price(each)</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>';
		while($row = mysqli_fetch_array($result)) {
			echo '

			<tr>
				<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_name" value="'.$row['item_name'].'" readonly></td>
				<td><input type="text" class="form-control w3-margin-bottom" name="edit_role_passwd" value="'.$row['item_price'].'" readonly></td>
				<td><a class="btn w3-center w3-large" title="Delete MenuItem" href="disable_item.php?item_id='.$row['item_id'].'"><i class="fa fa-trash"></i></a>
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



