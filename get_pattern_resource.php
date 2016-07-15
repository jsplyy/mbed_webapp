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
		curl_setopt ($ch, CURLOPT_URL, "https://api.connector.mbed.com/endpoints/".$_GET["pointid"].$_GET["patternid"]);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt ($ch, CURLOPT_HEADER, 1); //取得返回头信息
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书   
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
		$file_contents = curl_exec($ch);  
		curl_close($ch);  
		#echo $file_contents;
		$file_contents = json_decode($file_contents);
		#var_dump($file_contents);
		$endpointsNumbers = count($file_contents);
	 ?>
	 <html>
		<head>
			<link REL="SHORTCUT ICON" HREF="./img/favicon.ico">
			<title>mbed clients</title>
			<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
			<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
			<script type="text/javascript">

			</script>
		</head>
	 <body>
	 	<div class="container">
	 		<h3><img src="./img/NXP_logo.png">  Here is all the information about board LED pattern</h3>
			<hr>
			<h5><strong>Clinet board ID:</strong><?php echo $_GET["pointid"] ?>  <strong><a href="./index.php" style="float: right">返回主页</a></strong></h5><hr>			
			<p>LED Pattern</p>
	 	</div>
	 </body>
	 </html>
