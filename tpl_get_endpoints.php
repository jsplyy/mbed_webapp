<!DOCTYPE html>
<html>
	<head>
		<title>mbed clients</title>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<h3>Here is all the connected mbed clients:</h3>
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
								echo '<td><button class="btn btn-warning" onclick=getresource()>resource</button></td>';
								echo "</tr>";
							}		
						 ?>
					</tbody>
				</table>
		</div>
	</body>
</html>