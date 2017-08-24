<?php
include('../../db_conn/conn.php');
if($_POST['menuRank_category'])
{
	$menuRank_category=$_POST['menuRank_category'];

	switch ($menuRank_category) {
		case 'top_nonAC':

		$sql="SELECT * FROM menu_items WHERE status='0' AND visible='1' ORDER BY ordered_count DESC LIMIT 5";
		$result = mysqli_query($conn,$sql);
		$count=0;    
		echo '<table class="table table-striped w3-white" style="margin-top: 0px">';   
		while($row = mysqli_fetch_array( $result))
		{
			$count++;
			echo '
			<tr>
				<td class="w3-center">'.$count.'</td>
				<td class="w3-center">'.$row['item_name'].'</td>
				<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
			</tr>
			';
		}
		echo '</table>'; 

		break;
		case 'top_AC':

		$sql="SELECT * FROM menu_items WHERE status='1' AND visible='1' ORDER BY ordered_count DESC LIMIT 5";
		$result = mysqli_query($conn,$sql);
		$count=0;    
		echo '<table class="table table-striped w3-white" style="margin-top: 0px">';   
		while($row = mysqli_fetch_array( $result))
		{
			$count++;
			echo '
			<tr>
				<td class="w3-center">'.$count.'</td>
				<td class="w3-center">'.$row['item_name'].'</td>
				<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
			</tr>
			';
		}
		echo '</table>'; 
		
		break;
		case 'lowest_nonAC':

		$sql="SELECT * FROM menu_items WHERE status='0' AND visible='1' ORDER BY ordered_count LIMIT 5";
		$result = mysqli_query($conn,$sql);
		$count=0;    
		echo '<table class="table table-striped w3-white" style="margin-top: 0px">';   
		while($row = mysqli_fetch_array( $result))
		{
			$count++;
			echo '
			<tr>
				<td class="w3-center">'.$count.'</td>
				<td class="w3-center">'.$row['item_name'].'</td>
				<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
			</tr>
			';
		}
		echo '</table>'; 
		
		break;
		case 'lowest_AC':

		$sql="SELECT * FROM menu_items WHERE status='1' AND visible='1' ORDER BY ordered_count LIMIT 5";
		$result = mysqli_query($conn,$sql);
		$count=0; 
		echo '<table class="table table-striped w3-white" style="margin-top: 0px">';   
		while($row = mysqli_fetch_array( $result))
		{
			$count++;
			echo '
			<tr>
				<td class="w3-center">'.$count.'</td>
				<td class="w3-center">'.$row['item_name'].'</td>
				<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
			</tr>
			';
		}
		echo '</table>';   

		break;

		default:

 		$sql="SELECT * FROM menu_items WHERE visible='1' LIMIT 5";
		$result = mysqli_query($conn,$sql);
		$count=0; 
		echo '<table class="table table-striped w3-white" style="margin-top: 0px">';   
		while($row = mysqli_fetch_array( $result))
		{
			$count++;
			echo '
			<tr>
				<td class="w3-center">'.$count.'</td>
				<td class="w3-center">'.$row['item_name'].'</td>
				<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
			</tr>
			';
		}
		echo '</table>';

		break;
	}



//echo "</select>";
	mysqli_close($conn);

}
?>