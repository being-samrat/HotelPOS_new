<?php
error_reporting(E_ERROR | E_PARSE);

include("../db_conn/conn.php");
extract($_POST);
$item_image=($_FILES['item_image']['name']);
$target_file="";

if(isset($_POST['updateMenu'])){

    if($item_image==''){
//if image is not being changed then keep it as it as...............
        $target_file= $item_image_hidden;
    }
    else{
// Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["item_image"]["tmp_name"]);
        if($check !== false) {
//echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image or more than required size.')</script>";
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
    $target_file = $target_dir.strtoupper($item_name[0])."0".$cat_id."0".$item_id.basename($_FILES["item_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists replace it..................
    if (file_exists($target_file)) {    
        unlink("$target_file"); 
    }
// Check file size
    if ($_FILES["item_image"]["size"] > 5000000) {
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
    if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
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
//img upload end------------------------------------
}
$item_details=$_POST['item_info'];

if($item_details=' '){
    $item_details="Description Not Available !!!";
}

$sql="UPDATE menu_items SET item_name='".$item_name."', item_image='".$target_file."', item_price='".$item_price."', item_info='".$item_details."' WHERE item_id='".$item_id."'";

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