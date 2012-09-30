<?php /**/ ?><?php 
require_once('xml_configs.php');

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

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

// Search the rows in the markers table
$query = sprintf("SELECT Location, Street_Side, Ward, Latitude, Longitude, Street_Line, ( 3959 * acos( cos( radians('%s') ) * cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( Latitude ) ) ) ) AS distance FROM RPP HAVING distance < '%s' ORDER BY distance",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($radius));
$result = mysql_query($query);
$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
 	$node = $dom->createElement("line");
  
 	$newnode = $parnode->appendChild($node);
 	$newnode->setAttribute("Location", $row['Location']);
 	$newnode->setAttribute("Street_Side", $row['Street_Side']);
 	$newnode->setAttribute("Ward", $row['Ward']);
 	$newnode->setAttribute("Color", "#356AA0");
 	$newnode->setAttribute("Width", "4");
 	
  	$ok =  explode(',1 ',$row['Street_Line']);
 	foreach($ok as $l) {
 		$latlng = explode(',', $l);
 			
 		$line = $dom->createElement("point");
 		$street_line = $newnode->appendChild($line);
 		
 		$street_line->setAttribute("latitude", trim($latlng[1]));
 		$street_line->setAttribute("longitude", trim($latlng[0]));
 	}
}

echo $dom->saveXML();
?>
