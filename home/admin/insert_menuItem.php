<?php 

error_reporting(E_ERROR | E_PARSE);
include_once("../db_conn/conn.php");

extract($_POST);
$item_image="";
$item_image=($_FILES['item_imageFile']['name']);
$target_file="";

if($new_itemName=='' || $new_itemPrice=='' || $cat_id=='Select Category'|| $item_image=''){
	echo 'Check every Fields are filled or not!!!';	
}
else{
	if($menuAC=='1'){
		$new_itemName=$new_itemName." (A/c)";
	}
	$sql="SELECT * FROM menu_items WHERE LOWER(item_name)=LOWER('".$new_itemName."') AND visible=1 ";
	$result=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($result);

	if ($count > 0) {
		echo 'Menu Item already exist!!! Try different';
		//die();
	}

	else{

		if($item_image!=''){
	// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["item_imageFile"]["tmp_name"]);
			if($check !== false) {

				$uploadOk = 1;
			} else {
				echo "<script>alert('File is not an image or Is more than required size.')</script>";
				$uploadOk = 0;
				echo '<div class="w3-displaymiddle w3-large">
				<span>Image upload Guide:</span>
				<ol>
					<li>File should be an image file.</li>
					<li>Image size should be less than 2MB</li>
					<li>Image must be in jpg,jpeg,png or gif format</li>
				</ol>
				<a href="admin_manageSettings.php">Back to Settings Page</a>
			</div>';
			die();
		}
//img upload code-----------------------------------
		$target_dir = "../images/Menu_images/";
		$target_file = $target_dir.strtoupper($new_itemName[0])."0".$cat_id."0".basename($_FILES["item_imageFile"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists replace it..................
		if (file_exists($target_file)) {    
			unlink("$target_file"); 
		}
// Check file size
		if ($_FILES["item_imageFile"]["size"] > 2000000) {
			echo "<script>alert('Sorry, your file is too large.')</script>";
			$uploadOk = 0;
			echo '<div class="w3-displaymiddle w3-large">
			<span>Image upload Guide:</span>
			<ol>
				<li>File should be image.</li>
				<li>Image size should be less than 2MB</li>
				<li>Image must be in jpg,jpeg,png or gif format</li>
			</ol>
			<a href="admin_manageSettings.php">Back to Settings Page</a>
		</div>';
		die();
	}
// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
	$uploadOk = 0;
	echo '<div class="w3-displaymiddle w3-large">
	<span>Image upload Guide:</span>
	<ol>
		<li>File should be image.</li>
		<li>Image size should be less than 2MB</li>
		<li>Image must be in jpg,jpeg,png or gif format</li>
	</ol>
	<a href="admin_manageSettings.php">Back to Settings Page</a>
</div>';
die();
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "<script>alert('Sorry, your file was not uploaded.";
	echo '<div class="w3-displaymiddle w3-large">
	<span>Image upload Guide:</span>
	<ol>
		<li>File should be image.</li>
		<li>Image size should be less than 2MB</li>
		<li>Image must be in jpg,jpeg,png or gif format</li>
	</ol>
	<a href="admin_manageSettings.php">Back to Settings Page</a>
</div>';
die();
// if everything is ok, try to upload file
} else {
	
	if (move_uploaded_file($_FILES["item_imageFile"]["tmp_name"], $target_file)) {

        //echo "The file ". basename( $_FILES["item_image"]["name"]). " has been uploaded.";
	} else {
		echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
		echo '<div class="w3-displaymiddle w3-large">
		<span>Image upload Guide:</span>
		<ol>
			<li>File should be image.</li>
			<li>Image size should be less than 2MB</li>
			<li>Image must be in jpg,jpeg,png or gif format</li>
		</ol>
		<a href="admin_manageSettings.php">Back to Settings Page</a>
	</div>';
	die();
}
}
}
else{
	$target_file="../images/Menu_images/default_menu.png";
}
//img upload end------------------------------------

$newcat_sql="INSERT INTO menu_items(item_image,item_name,item_price,cat_id,status) VALUES ('".$target_file."','".$new_itemName."','".$new_itemPrice."','".$cat_id."','".$menuAC."')";


if ((mysqli_query($conn,$newcat_sql)==TRUE)) {
	echo "<script>alert('Menu Item Added');
  window.location.href='admin_manageSettings.php';
</script>";
}
else{
	echo "<script>alert('Menu Item Addition failed!!!');
  window.location.href='admin_manageSettings.php';
</script>"; 
}
}

mysqli_close($conn);	
}


?>