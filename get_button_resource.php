	<?php 



function stream_notification_callback($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) {

    switch($notification_code) {
        case STREAM_NOTIFY_RESOLVE:
        case STREAM_NOTIFY_AUTH_REQUIRED:
        case STREAM_NOTIFY_COMPLETED:
        case STREAM_NOTIFY_FAILURE:
        case STREAM_NOTIFY_AUTH_RESULT:
            var_dump($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max);
            /* Ignore */
            break;

        case STREAM_NOTIFY_REDIRECTED:
            echo "Being redirected to: ", $message;
            break;

        case STREAM_NOTIFY_CONNECT:
            echo "Connected...";
            break;

        case STREAM_NOTIFY_FILE_SIZE_IS:
            echo "Got the filesize: ", $bytes_max;
            break;

        case STREAM_NOTIFY_MIME_TYPE_IS:
            echo "Found the mime-type: ", $message;
            break;

        case STREAM_NOTIFY_PROGRESS:
            echo "Made some progress, downloaded ", $bytes_transferred, " so far";
            break;
    }
    echo "\n";
}

// $ctx = stream_context_create();
// stream_context_set_params($ctx, array("notification" => "stream_notification_callback"));

// file_get_contents("http://php.net/contact", false, $ctx);
// 	echo 



	$headers = array(
            'Content-Type: application/json',
            "Authorization: Bearer 4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr",
            "User-Agent: curl/7.19.7 (x86_64-redhat-linux-gnu) libcurl/7.19.7 NSS/3.21 Basic ECC zlib/1.2.3 libidn/1.18 libssh2/1.4.2",
            "Host: api.connector.mbed.com",
            "Accept: */*",
            "X-Requested-With: XMLHttpRequest",
            "Connection: keep-alive"
        );

		$ch = curl_init();  
		$timeout = 500;  
		curl_setopt ($ch, CURLOPT_URL, "https://api.connector.mbed.com/endpoints/v2/".$_GET["pointid"].$_GET["buttonid"]);
		#curl_setopt ($ch, CURLOPT_URL, "https://api.connector.mbed.com/endpoints/1728956523#277683b2-0468-4690-a7b5-582129057200@9a3572f4-a2af-4ec2-a232-cf75fe6bf7a1/3200/0/5501");

		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($ch, CURLOPT_HEADER, 1); //取得返回头信息
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书   
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  			
		$ctx = stream_context_create();
		stream_context_set_params($ctx, array("notification" => "stream_notification_callback"));
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
			<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
			<script type="text/javascript">
				function sgetxml(){
					// $.get("https://api.connector.mbed.com/endpoints/277683b2-0468-4690-a7b5-582129057200//3200/0/5501/",null,function callback(data){$("#result").html(data);});
					//$.get("http://www.baidu.com",null,function callback(data){$("body").html(data);});
					// $.get("./index.php",function(data,status){
    	// 				$("#countt").html(data);
    					//alert("Data: " + data + "\nStatus: " + status);
    	// 			var request = new XMLHttpRequest();
					// request.open('GET', 'http://www.baidu.com/', false); 
					// #request.open('GET', './index.php', false);
					// request.send(null);
					// if (request.status === 200) {
					//   alert(request.responseText);
					// }
    					//alert($.ajax({"GET","./index.php",async:false});
    				alert($.getJSON("https://www.baidu.com"));
    			}

			</script>
		</head>
	 <body>
	 	<div class="container">
	 		<h3><img src="./img/NXP_logo.png">  Here is all the information about board button</h3>
			<hr>
			<h5><strong>Clinet board ID:</strong><?php echo $_GET["pointid"] ?>  <strong><a href="./index.php" style="float: right">返回主页</a></strong></h5><hr>
			<p> The button contains one property (click count). When `handle_button_click` is executed, the counter updates.</p>
			<p id="countt">click count 7 times</p>
			<button class="btn btn-warning" onclick=sgetxml()>getxml</button>

	 	</div>
	 </body>
	 </html>
