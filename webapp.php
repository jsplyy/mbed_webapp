<!DOCTYPE html>
<html>
<head>
	<title>mbed app</title>
</head>
<body>
	<?php 

	$headers = array(
            'Content-Type: application/json',
            "Authorization: Bearer 4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr",
            "User-Agent: curl/7.19.7 (x86_64-redhat-linux-gnu) libcurl/7.19.7 NSS/3.21 Basic ECC zlib/1.2.3 libidn/1.18 libssh2/1.4.2",
            "Host: api.connector.mbed.com",
            "Accept: */*"
        );


		$ch = curl_init();  
		$timeout = 5;  
		curl_setopt ($ch, CURLOPT_URL, "https://api.connector.mbed.com/endpoints/");
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书   
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
		$file_contents = curl_exec($ch);  
		var_dump($file_contents);
		curl_close($ch);  
		echo $file_contents;	
		echo "hello world\n";
	 ?>
</body>
</html>