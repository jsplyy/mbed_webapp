<!DOCTYPE html>
<html>
	<head>
		<link REL="SHORTCUT ICON" HREF="./img/favicon.ico">
		<title>mbed clients</title>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
		<script type="text/javascript">
		function getNoresource(){
			window.location.href = "./index.php";
		}		
		function getButtonResource(pointid,buttonid){
			var url = "./get_button_resource.php?pointid=";
			window.location.href = url + pointid + "&buttonid=" + buttonid;
		}
		function getBlinkResource(pointid,blinkid){
			var url = "./get_blink_resource.php?pointid=";
			window.location.href = url + pointid + "&blinkid=" + blinkid;
		}
		function getPatternResource(pointid,patternid){
			var url = "./get_pattern_resource.php?pointid=";
			window.location.href = url + pointid + "&patternid=" + patternid;
		}

	</script>
	</head>
	<body>
		<div class="container">
			<h3><img src="./img/NXP_logo.png">  Here is all the open board resources in mbed client:</h3>
			<hr>
			<h5><strong>Clinet board ID:</strong><?php echo $_GET["pointid"] ?>  <strong><a href="./index.php" style="float: right">返回主页</a></strong></h5>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Resource name</th>
						<th>Resource ID</th>
						<th>status</th>
						<th>manage</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$endpointsNumbers = count($file_contents);
						for($i=0;$i<$endpointsNumbers;$i++)
						{
							echo "<tr>";
							if(property_exists($file_contents[$i], "rt"))
							{
								echo "<td>".$file_contents[$i]->{"rt"}."</td>";
								echo "<td>".$file_contents[$i]->{"uri"}."</td>";
								echo "<td>"."active</td>";
								switch ($file_contents[$i]->{"rt"}) {
									case 'Blink':
										echo '<td><button class="btn btn-warning" onclick=getBlinkResource("'. $_GET["pointid"].'","'.$file_contents[$i]->{"uri"}.'")>Start</button></td>';
										break;
									case 'Pattern':
										echo '<td><button class="btn btn-warning" onclick=getPatternResource("'. $_GET["pointid"].'","'.$file_contents[$i]->{"uri"}.'")>SetPT</button></td>';
										break;
									case 'Button':
										echo '<td><button class="btn btn-warning" onclick=getButtonResource("'. $_GET["pointid"].'","'.$file_contents[$i]->{"uri"}.'")>GetBT</button></td>';
										break;
									default:
										echo '<td><button class="btn btn-warning" onclick=getNoresource()>control</button></td>';
										break;
								}								
							}
							else{
								echo "<td>object</td>";
								echo "<td>".$file_contents[$i]->{"uri"}."</td>";
								echo "<td>"."active</td>";
								echo '<td><button class="btn btn-warning" onclick=getNoresource()>control</button></td>';
							}
							echo "</tr>";
						}		
					 ?>
				</tbody>
			</table>
		</div>
	</body>
</html>