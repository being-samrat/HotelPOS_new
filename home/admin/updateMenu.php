<?php
//error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
extract($_POST);
// print_r($_FILES["item_image"]["name"]);
// die();
if(isset($_POST['updateMenu'])){
	
$item_image=($_FILES['item_image']['name']);


//img upload code-----------------------------------
$target_dir = "../images/Menu_images/";
$target_file = $target_dir.strtoupper($item_name[0])."0".$cat_id."0".$item_id.basename($_FILES["item_image"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["item_image"]["tmp_name"]);
    if($check !== false) {
//echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<script>alert('File is not an image.')</script>";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists.')</script>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["item_image"]["size"] > 1000000) {
    echo "<script>alert('Sorry, your file is too large.')</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["item_image"]["name"]). " has been uploaded.";
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
    }
}
//img upload end------------------------------------
	$sql="UPDATE menu_items SET item_name='".$item_name."', item_image='".$target_file."', item_price='".$item_price."', item_info='".$item_info."' WHERE item_id='".$item_id."'";

	if((mysqli_query($conn,$sql))==TRUE){
		echo "<script>alert('Menu Item Updated');
		window.location.href='admin_manageSettings.php';
	</script>";
}
else {
	# code...
	mysqli_error();
}
}
mysqli_close($conn);
?>