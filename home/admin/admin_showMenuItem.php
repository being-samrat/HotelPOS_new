<?php 	
include('../db_conn/conn.php');
session_start();
if($_POST['id'])
{
	$id=$_POST['id'];
	$sql="SELECT * FROM menu_category mc,menu_items mi WHERE mc.cat_id=mi.cat_id AND cat_name = '".$id."'";
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
				<td>'.$row['item_name'].'</td>
				<td>'.$row['item_price'].'</td>
				<td><label class="w3-small"><input id="'.$row['item_id'].'" type="checkbox" name="disable_item">Disable</label></td>
			</tr>

			';
			

		}
		
	echo '</tbody>
</table>';

//echo "</select>";
mysqli_close($conn);

}
?>  



