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

		$createHotelTable_sql = "CREATE TABLE IF NOT EXISTS tasks (
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
?>