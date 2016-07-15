<!DOCTYPE html>
<html>
	<head>
		<link REL="SHORTCUT ICON" HREF="./img/favicon.ico">
		<title>mbed clients</title>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
		<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
		<script type="text/javascript">
			function getresource(pointid){
				//alert(pointid);
				var url = "./get_resource.php?pointid=";
				window.location.href = url + pointid;

			}
		</script>
	</head>
	<body>
		<div class="container">
			<h3><img src="./img/NXP_logo.png">  Here is all the connected mbed clients:</h3>
			<hr>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>point ID</th>
							<th>status</th>
							<th>watch</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$endpointsNumbers = count($file_contents);
							for($i=0;$i<$endpointsNumbers;$i++)
							{
								echo "<tr>";
								echo "<td>".$file_contents[$i]->{"name"}."</td>";
								echo "<td>"."active</td>";
								echo '<td><button class="btn btn-warning" onclick=getresource("'. $file_contents[$i]->{"name"}. '")>resource</button></td>';
								#echo '<td><button class="btn btn-warning" onclick=getresource("gggg")>resource</button></td>';
								echo "</tr>";
							}		
						 ?>
					</tbody>
				</table>
		</div>
	</body>
</html>
