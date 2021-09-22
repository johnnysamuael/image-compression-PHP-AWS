<!DOCTYPE html>
<html>

<head>
    <title>Flam Assignment :</title>
	<h1> CN Mini Project - Johny Samuael & Saket Kattuboina & Aditya Katti</h1>
	</head>

<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	
	$givenquality = $_POST['quality'];
	if ($givenquality==''){
		$givenquality=100;
	}
	
	 $width = $_POST['width'];
	 $height = $_POST['height'];
	$st=time();
	$t = $st;
	//echo "quality".$givenquality." "."width". $width." height ".$height;
    $file_name = $_FILES["image_file"]["name"];
    $file_type = $_FILES["image_file"]["type"];
    $temp_name = $_FILES["image_file"]["tmp_name"];
    $file_size = $_FILES["image_file"]["size"];
    $error = $_FILES["image_file"]["error"];
    if (!$temp_name)
    {
        echo "ERROR: Please browse for file before uploading";
        exit();
    }
    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);
        //echo "Image uploaded successfully.";
    }
	   function resize_image($source_url, $destination_url,$height, $width,$quality)
    {
		  
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
		  
		$imgResized = imagescale($image , $width,$height); 
        imagejpeg($imgResized, $destination_url, $quality);
        //echo "Image uploaded successfully.";
    }
    if ($error > 0)
    {
        echo $error;
    }
    else if (($file_type == "image/gif") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/pjpeg"))
    {
		
		if($height=='' and $height=='') {
			if ($givenquality>100 or $givenquality < 0 ) {
		echo "quality cannot be more than 100 or less than 0";
			exit();
	}
		 $filename = compress_image($temp_name, $t."compressed_".$file_name, $givenquality);
			echo '<img src="' . $t. "compressed_".$file_name . '" alt="error">'; 
				echo "<h1> Original size :" . (filesize($temp_name)/1000)."kb </h1>";
			echo " <h1>compressed size :" . (filesize($t."compressed_".$file_name)/1000)."</h1>";
		
		} else {
			if ($givenquality>100 or $givenquality < 0 ) {
		echo "quality cannot be more than 100 or less than 0";
			exit();
	}
			 $filename1 = resize_image($temp_name,  $t. "resized_".$file_name,$height,$width,$givenquality);
			 echo '<img src="' . $t."resized_".$file_name . '" alt="error">'; 
			echo "<h1>Original size :" . (filesize($temp_name)/1000)."kb </h1>";
			echo "<h1>Size after resizing :" . (filesize( $t."resized_".$file_name)/1000)."kb</h1>";
			
		}
       
		
	    
    }
    else
    {
        echo "Uploaded image should be jpg or gif or png.";
    }
} ?>
    <form action='' method='POST' enctype='multipart/form-data'>
        <input name="image_file" type="file" accept="image/*">
		<label for="blan">:</label><br>
		<label for="fname">Quality%</label><br>
		<input name="quality" type="number">
		<label for="blan">%</label><br>
		<label for="fname">Height</label><br>
		<input name="height" type="number">
		<label for="blan">:</label><br>
		<label for="fname">WIdth:</label><br>
		<input name="width" type="number">
        <button type="submit">SUBMIT</button>
    </form>
	
</body>

</html>
