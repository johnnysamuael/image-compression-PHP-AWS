# Image Compression and resizing using PHP
![./images/Screenshot 2021-09-24 at 2.16.06 PM.png]
Image compression and rendering web service/application.

This is done using PHP and can be tested with the hosted version on my personal server t : http://floodanalyser.com/flamapp/flam.php


This form sends a post request with the following parameters (Image, quality, height and width). If height and width are not specified the quality is reduced as per the parameter inputted. If quality and the hxw are provided, the image is compressed and resized.

This can be scaled up with CDN integrated with apache also by load balancing. As per the time constraint, the images are resized and compressed as per request. This can be later converted to an API based service. This also works as an API if post an image along with the parameters. You can use postman or Hoppscotch to test it out (parameters: image_file, quality, height, width) with a form-encoded header.

This creates a token based on the timestamp and appends it with every image uploaded so there is no clash with other service requests with the same name. We also can use the temporary image path provided from the local device but it's vulnerable to change with refresh or no activity. I have also included a statement at the end of compression which shows if its original size vs compressed size

Certain test cases such as the quality cannot be less than 0 or higher than 100, or the file not being uploaded and other basic test cases have been checked and tested
