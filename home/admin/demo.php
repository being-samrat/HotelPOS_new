<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Manage Settings</title>
	<link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../assets/css/w3.css">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/alert/jquery-confirm.css">

	<script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/css/alert/jquery-confirm.js"></script>

	<script>
		$(document).ready(function() {
			var max_fields      = 10;
			var wrapper         = $(".addTable_container"); 
			var add_button      = $(".add_form_field"); 

			var x = 1; 
			$(add_button).click(function(e){ 
				e.preventDefault();
				if(x < max_fields){ 
					x++; 
            $(wrapper).append('<div><label>Table No: </label>&nbsp;<input type="text" autocomplete="off" name="tableNO[]" style="width: 60px;" required/><a href="#" class="delete w3-grey w3-margin-left fa fa-remove w3-padding-tiny w3-text-white" title="Delete table"></a></div>'); //add input box
            
        }
        else
        {
        	alert('You Reached the limits')
        }
    });

			$(wrapper).on("click",".delete", function(e){ 
				e.preventDefault(); $(this).parent('div').remove(); x--;
			})
		});
	</script>
	<style type="text/css">
		.table_view{
			background-image: url(adminImg/empty.png);
			background-size: 40px;
			background-repeat: no-repeat;
			background-position: left;
			background-origin: content-box;
			padding-top:15px;
		}
	</style>
</head>
<body style="background-color: #E4E4E4">
<?php
	$name = ''; $type = ''; $size = ''; $error = '';
	function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($source_url);

    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($source_url);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($source_url);

    		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}

	if ($_POST) {

    		if ($_FILES["file"]["error"] > 0) {
        			$error = $_FILES["file"]["error"];
    		} 
    		else if (($_FILES["file"]["type"] == "image/gif") || 
			($_FILES["file"]["type"] == "image/jpeg") || 
			($_FILES["file"]["type"] == "image/png") || 
			($_FILES["file"]["type"] == "image/pjpeg")) {

        			$url = 'destination .jpg';

        			$filename = compress_image($_FILES["file"]["tmp_name"], $url, 80);
        			$buffer = file_get_contents($url);

        			/* Force download dialog... */
        			header("Content-Type: application/force-download");
        			header("Content-Type: application/octet-stream");
        			header("Content-Type: application/download");

			/* Don't allow caching... */
        			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        			/* Set data type, size and filename */
        			header("Content-Type: application/octet-stream");
        			header("Content-Transfer-Encoding: binary");
        			header("Content-Length: " . strlen($buffer));
        			header("Content-Disposition: attachment; filename=$url");

        			/* Send our file... */
        			echo $buffer;
    		}else {
        			$error = "Uploaded image should be jpg or gif or png";
    		}
	}
?>
<html>
    	<head>
        		<title>Php code compress the image</title>
    	</head>
    	<body>

		<div class="message">
                    	<?php
                    		if($_POST){
                        		if ($error) {
                            		?>
                            		<label class="error"><?php echo $error; ?></label>
                        <?php
                            		}
                        	}
                    	?>
                	</div>
		<fieldset class="well">
            	    	<legend>Upload Image:</legend>                
			<form action="" name="myform" id="myform" method="post" enctype="multipart/form-data">
				<ul>
			            	<li>
						<label>Upload:</label>
			                                <input type="file" name="file" id="file"/>
					</li>
					<li>
						<input type="submit" name="submit" id="submit" class="submit btn-success"/>
					</li>
				</ul>
			</form>
		</fieldset>
	</body>
</html>
</div>
</body>
</html>