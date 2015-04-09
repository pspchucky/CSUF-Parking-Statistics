<?php
//Nutwood Structure
//State College Structure
//Eastside Structure
//Lot A & G

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
$structures = array('Nutwood Structure','State College Structure','Eastside Structure','Lot A & G');
$json_structures = array('nutwood','state_college','eastside','lot_a_g');
$max_caps = array(2439,1339,1365,1865);
$counts = array();
//$times = array();
$html = file_get_contents('https://parking.fullerton.edu/parkinglotcounts/Android.aspx');
$time = time();
$data = array();
$j = 0;
for($i = 2; $i-2 < count($structures); $i++){
	
	//Get Times - Damn it Double Digits!
	//$findme = "gvAvailability_ctl0". $i ."_Label3";
	//$pos = strpos($html, $findme);
	//$times[$j] = substr($html,$pos+29,19);
	
	//Get Avaliable Spaces
	$findme = "gvAvailability_ctl0". $i ."_Label4";
	$pos = strpos($html, $findme);
	$counts[$j] = intval(substr($html,$pos+29,20));
	$sql = "INSERT INTO ". $json_structures[$i-2] ." (avaliable, max, time_retrieved) VALUES ('". $counts[$j] ."', '". $max_caps[$i-2] ."', '". $time ."')";
	mysqli_query($conn, $sql);
	$j++;
}

for($i = 0; $i < count($structures); $i++)
{
	$data[$i] = array($json_structures[$i] => array('max' => $max_caps[$i], 'avaliable' => $counts[$i] , 'time_retrieved' => $time));
}

$fin = array("structures" => $data);

//Store away results
file_put_contents ( "latest.json", json_encode($fin,JSON_PRETTY_PRINT) );
?>