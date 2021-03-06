<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "hotel";

$conn = mysqli_connect($servername, $db_username, $db_password,$db_name);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());

	$createDB_sql = "CREATE DATABASE ".$db_name." ";
	if (mysqli_query($conn, $createDB_sql)) 
	{
		$conn = mysqli_connect($servername, $db_username, $db_password,$db_name);
	//echo "Database created successfully";

		$createHotelTable_sql = "CREATE TABLE IF NOT EXISTS hotel_tables (
		task_id INT(11) NOT NULL AUTO_INCREMENT,
		subject VARCHAR(45) DEFAULT NULL,
		start_date DATE DEFAULT NULL,
		end_date DATE DEFAULT NULL,
		description VARCHAR(200) DEFAULT NULL,
		PRIMARY KEY (task_id)
		) ENGINE=InnoD";
		mysqli_query($conn, $createHotelTable_sql);
	} 
	else 
	{
		echo "Error creating database: " . mysqli_error($conn);
	}
}
//.....................................query to change datatype of column ........................................
$Alter_tab = "ALTER TABLE user_login CHANGE username username VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
mysqli_query($conn, $Alter_tab);


//.....................................script to add new column ........................................
$addColumn_join="SELECT waiter FROM kot_table";
$addColumn_join_res=mysqli_query($conn,$addColumn_join);
if($addColumn_join_res==FALSE)
{
	$kot_alt_sql="ALTER TABLE kot_table ADD waiter VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER parcel_id; ";
	mysqli_query($conn,$kot_alt_sql);
}

$addColumn_waiter="SELECT waiter FROM order_table";
$addColumn_waiter_res=mysqli_query($conn,$addColumn_waiter);
if($addColumn_waiter_res==FALSE)
{
	$order_alt_sql="ALTER TABLE order_table ADD waiter VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER parcel_id; ";
	mysqli_query($conn,$order_alt_sql);
}
?>