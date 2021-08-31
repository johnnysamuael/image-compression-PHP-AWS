<!DOCTYPE html>
<html>

<head>
    <title>Flam Assignment :</title>
	<h1> Flam Backend Assignment</h1>
	<h2> This form sends a post request with the following parameters (Image, quality, height and width). If height and width are not specified the quality is reduced as per the parameter inputted. If quality and the HxW are provided, the image is compressed and resized.</h2>
	<h3> This can be scaled up with CDN integrated with apache also by load balancing. As per the time constraint, the images are resized and compressed as per request. This can be later converted to a API based service. This also works as an API if post a image along with the parameters. You can use postman or Hoppscotch to test it out (parameters: image_file,quality,height,width) with form encoded header. </h3>
	<h3> This creates a token based on the timestamp and appends it with every image uploaded so we there is no clash with other service requests with the same name. We also can use the temporary image path provided from the local device but its vulnerable to change with refresh or no activity. I have also included a satement at the end of compression which shows if its original size vs compressed size</h3>
	<h4> Certain test cases such as the quality cannot be less than 0 or higher than 100, or the file not being uploaded and other basic test cases have been checked and tested</h4>
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
		 $filename = compress_image($temp_name, "uploads/" . $t."compressed_".$file_name, $givenquality);
			echo '<img src="' . "uploads/" . $t. "compressed_".$file_name . '" alt="error">'; 
				echo "<h1> Original size :" . (filesize($temp_name)/1000)."kb </h1>";
			echo " <h1>compressed size :" . (filesize("uploads/" . $t."compressed_".$file_name)/1000)."</h1>";
		
		} else {
			if ($givenquality>100 or $givenquality < 0 ) {
		echo "quality cannot be more than 100 or less than 0";
			exit();
	}
			 $filename1 = resize_image($temp_name, "uploads/" . $t. "resized_".$file_name,$height,$width,$givenquality);
			 echo '<img src="' . "uploads/" .  $t."resized_".$file_name . '" alt="error">'; 
			echo "<h1>Original size :" . (filesize($temp_name)/1000)."kb </h1>";
			echo "<h1>Size after resizing :" . (filesize("uploads/" . $t."resized_".$file_name)/1000)."kb</h1>";
			
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
