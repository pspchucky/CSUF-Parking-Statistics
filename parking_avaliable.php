<?php
date_default_timezone_set('America/Los_Angeles');
$json_file = file_get_contents('api/latest.json');
$json = json_decode($json_file, true);
$structures = array('Nutwood Structure','State College Structure','Eastside Structure','Lot A & G');
$max_caps = array();
$avaliable = array();
$json_structures = array();
$time = array();

	for($i = 0; $i < count($json["structures"]); $i++){
		$max_caps[$i] = current($json["structures"][$i])["max"];
		$avaliable[$i] = current($json["structures"][$i])["avaliable"];
		$time[$i] = current($json["structures"][$i])["time_retrieved"];
		$json_structures[$i] = key($json["structures"][$i]);
	}
	for($i = 0; $i < count($json["structures"]); $i++)
	{
		$percent = round((($max_caps[$i]-$avaliable[$i])/$max_caps[$i])*100,2);
		echo $structures[$i] . " has " . $avaliable[$i] . " parking spaces avaliable with a maximum capacity of ". $max_caps[$i] ." (". $percent ."% filled) @ ". $time[$i] ."<br>";
	}
?>