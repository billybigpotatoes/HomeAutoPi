<?php
/* IP Camera Proxy
 * PHP frontend to interface with cheap password-protected webcams and 
 * pull images for public display on a website
 * 
 * Copyright Will Bradley, 2012 (www.zyphon.com)
 * Distributed under a Creative Commons Attribution 3.0 license
 * http://creativecommons.org/licenses/by/3.0/
 *
 * To use, change EXAMPLE.COM, the port number, EXAMPLEUSER, & EXAMPLEPASSWORD
 * to their correct values for your setup. I use cheap Hootoo-brand cameras
 * for my setup, yours may be different regarding snapshot urls and auth
 * mechanisms. Then, host this on a PHP site and access it at 
 * /snapshot.php?camera=1
 * 
 */

	$rand = rand(1000,9999);
	$url = 'http://10.0.1.107:80/snapshot.cgi?'.$rand;

	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl_handle,CURLOPT_URL,$url); 
	curl_setopt($curl_handle, CURLOPT_USERPWD, "boss:boss");
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);

	if (empty($buffer))
	{
	    print "";
	}
	elseif($buffer == "Can not get image.")
	{
	    print "Can not get image.";
	}
	else
	{
	    header("Content-Type: image/jpeg");
	    print $buffer;
	}

?>
