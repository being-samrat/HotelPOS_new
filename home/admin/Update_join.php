<?php
error_reporting(E_ERROR | E_PARSE);

include_once("../db_conn/conn.php");
if (empty($_POST['join_tab']) || ($_POST['join_tab'][1])==''){
	echo "You must select at least two tables."; 
}

else {
	$join_parent="";
	$join_parentStatus="";
	$join_parent=$_POST['join_tab'][0];//0th index value...i.e. first elelment in array will be parent table.......................
	array_splice($_POST['join_tab'], 0, 1);//this shifts 1st index value to 0th index value.................................

	//script to check whether ac tables are connected to non-ac tables OR vice versa...................................
	$get_ParentStatus="SELECT * FROM hotel_tables WHERE table_id='$join_parent'";
	$get_ParentStatus_res=mysqli_query($conn,$get_ParentStatus);

	while($row = mysqli_fetch_array($get_ParentStatus_res))
	{
		$join_parentStatus=$row['status'];
	}

	$stat=array();
	foreach ($_POST['join_tab'] as $key) {
		
		$sql="SELECT * FROM hotel_tables WHERE table_id='$key'";
		$sql_res=mysqli_query($conn,$sql);

		while($row = mysqli_fetch_array( $sql_res))
		{
			
			if($join_parentStatus!=$row['status']){
				echo "You can't join A/c to Non-A/c Table OR vice versa !!!";
				die();
			}
			if($row['kot_open']=='1'){
				echo "Before joining, please print the KOT's of all joining tables !!!";
				die();
			}
		}

	}
	//end checking table status............................


	$kot_array=json_encode($_POST['join_tab'],true);


//getting id of next join_table record-------------------------------------------------
	$sql_getID="SELECT * FROM information_schema.TABLES WHERE TABLE_NAME = 'join_table'  AND TABLE_SCHEMA='$db_name'";
	$sql_getID_res=mysqli_query($conn,$sql_getID);
	$parentID="";
	while($row = mysqli_fetch_array( $sql_getID_res))
	{
		$parentID=$row['AUTO_INCREMENT'];
	}


//end----------------------------------------------------------

	$sql="INSERT INTO join_table (table_id,joint_tables,joined) VALUES ('$join_parent','$kot_array','1')";
	if((mysqli_query($conn,$sql))==TRUE){

		foreach ($_POST['join_tab'] as $key) {
			$update_stat="UPDATE hotel_tables SET join_id='0', occupied='1' WHERE table_id='$key'";
			$update_stat_parent="UPDATE hotel_tables SET join_id='$parentID',occupied='1' WHERE table_id='$join_parent'";
			mysqli_query($conn,$update_stat);
			mysqli_query($conn,$update_stat_parent);

		}
		echo "Tables joined successfully";
	}
	else{
		mysqli_error($conn);
		echo "Joining failed!!!";
	}
}
?>
