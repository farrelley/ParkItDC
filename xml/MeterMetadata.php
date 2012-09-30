<?php /**/ ?><?php 
require_once('xml_configs.php');

// Get parameters from URL
$meternum = $_GET["meternum"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("entry");
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
$query = sprintf("SELECT * from Hanson WHERE METERNUM = '%s'",
  mysql_real_escape_string($meternum));

$result = mysql_query($query);

$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  $node = $dom->createElement("meter");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("METERNUM", $row['METERNUM']);
  $newnode->setAttribute("SERVICE_PRIORITY", $row['SERVICE_PRIORITY']); 
  $newnode->setAttribute("SERVICE_CODE_DESC", $row['SERVICE_CODE_DESC']);
  $newnode->setAttribute("SERVICE_ORDER_DATE", $row['SERVICE_ORDER_DATE']);
  $newnode->setAttribute("SERVICE_ORDER_STATUS", $row['SERVICE_ORDER_STATUS']);
  $newnode->setAttribute("CALL_COUNT", $row['CALL_COUNT']);
  $newnode->setAttribute("RESOLUTION_DATE", $row['RESOLUTION_DATE']);
  $newnode->setAttribute("RESOLUTION", $row['RESOLUTION']);
  $newnode->setAttribute("SERVICE_DUE_DATE", $row['SERVICE_DUE_DATE']);
  $newnode->setAttribute("SERVICE_NOTES", $row['SERVICE_NOTES']);
  $newnode->setAttribute("LOCATION", $row['LOCATION']);
  $newnode->setAttribute("WARD", $row['WARD']);
}

echo $dom->saveXML();
?>
