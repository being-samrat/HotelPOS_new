<?php
$new_itemImage=($_FILES['new_itemImage']['name']);

$name_size=strlen($new_itemName);

//img upload code-----------------------------------
$target_dir = "Menu_images/";
$target_file = $target_dir.strtoupper($new_itemName[0]).strtoupper($new_itemName[$name_size])"_0".$cat_id."0".$ basename($_FILES["new_itemImage"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$target = "uploads/"; 
$target_d = $target.$place."_".$title.".".pathinfo($pic,PATHINFO_EXTENSION); 

if (move_uploaded_file($_FILES['file1']['tmp_name'], $target_d)) { 
  echo "The file ".basename($pic). "File has been uploaded to ".$target_d.", and your information has been added to the directory"; 
} else { 
  echo "Sorry, there was a problem uploading your file.";
} 
//image upload end----------------
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["new_itemImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["new_itemImage"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["new_itemImage"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["new_itemImage"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
//img upload end------------------------------------
?>