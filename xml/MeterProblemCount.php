<?php /**/ ?><?php 
require_once('xml_configs.php');

// Get parameters from URL
$MeterNum = $_GET["Meter"];


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
$query = sprintf("SELECT COUNT(*) AS METER_COUNT FROM Hanson WHERE METERNUM = '%s'",
  	mysql_real_escape_string($MeterNum));
  	
$result = mysql_query($query);

if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("METERNUM", $MeterNum);
  $newnode->setAttribute("METER_COUNT", $row['METER_COUNT']);
}

echo $dom->saveXML();
?>
