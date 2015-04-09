<?php


if(isset($_GET["structure"]) && isset($_GET["time"]) && isset($_GET["h"])){
	$structure_name = $_GET["structure"];
	if($structure_name != ""){
		switch ($structure_name) {
			case "nutwood":
			case "eastside":
			case "state_college":
			case "lot_a_g":
				$servername = "localhost";
				$username = "root";
				$password = "HeyYoDaddyOh1776";
				$dbname = "csuf_parking";

				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				date_default_timezone_set('America/Los_Angeles');
				$limit = intval(date('i'));
				$sql = "SELECT * FROM ( SELECT @row := @row +1 AS rownum, `avaliable`,`time_retrieved` FROM ( SELECT @row :=0) r, ". $structure_name ." ) ranked WHERE rownum % 6 = 1 AND `time_retrieved`<=". $_GET["time"] ." ORDER BY `ranked`.`rownum` ASC LIMIT " . $limit;	
				$result = mysqli_query($conn, $sql);

				if($result != false){
					if (mysqli_num_rows($result) > 0) {
						// output data of each row
						while($row = mysqli_fetch_assoc($result)) {
							echo $row["avaliable"] . ",";
						}
					} else {
						echo "0 results";
					}
				} else {
					echo "Invalid Query";
				}
				mysqli_close($conn);
				break;
			default:
				echo "Invalid structure '" . $structure_name . "'<br>";
				break;
		}
	}
}
?>