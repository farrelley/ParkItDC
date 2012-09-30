<?php /**/ ?><?php
require_once('scripts_configs.php');
/*
// Opens a connection to a mySQL server
$connection=mysql_connect (SERVER, USERNAME, PASSWORD);
if (!$connection) {
  die("Not connected : " . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db(SCHEMA, $connection);
if (!$db_selected) {
  die ("Can't use db : " . mysql_error());
}

$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)) {

$num = strpos($row['LOCATION'],"Washington");
//echo $num."<br />";
*/
	$xml =  simplexml_load_file("http://locations.pmi-parking.com/garages.xml");
	//echo count($xml->ID);
	for($i=0; $i < count($xml->ID); $i++) {
$sql = "INSERT INTO Garage (COMPANY, GARAGENUM, LOCATION, LATITUDE, LONGITUDE) VALUES (
		'".mysql_real_escape_string('Parking Management, Inc.')."',
		'".mysql_real_escape_string($xml->ID[$i])."',
		'".mysql_real_escape_string($xml->Address[$i])." Washington, DC',
		'".mysql_real_escape_string($xml->point[$i]['lat'])."',
		'".mysql_real_escape_string($xml->point[$i]['lng'])."');";
	echo $sql;
	echo "<br /><br />";
	}
	
?>
