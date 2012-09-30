<?php /**/ ?><?php 

require_once('xml_configs.php');

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];


//today's date and -30 date
//$today = date('Y-m-d');
//$todayminusthirty = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-30,   date("Y")));
//WHERE DATE between ".$today." and ".$todayminusthirty."

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
/*$query = sprintf("SELECT NAME, DATE, SHIFT, WARD, METHOD, LOCATION, NARRATIVE, LATITUDE, LONGITUDE, ( 3959 * acos( cos( radians('%s') ) * cos( radians( LATITUDE ) ) * cos( radians( LONGITUDE ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( LATITUDE ) ) ) ) AS distance FROM Auto_Crime HAVING distance < '%s' ORDER BY distance",
	mysql_real_escape_string($center_lat),
  	mysql_real_escape_string($center_lng),
  	mysql_real_escape_string($center_lat),
  	mysql_real_escape_string($radius));
*/
$query = sprintf("SELECT ac.NAME, ac.DATE, ac.SHIFT, ac.WARD, ac.METHOD, ac.LOCATION, ac.NARRATIVE, m.DESCRIPTION, ac.LATITUDE, ac.LONGITUDE, ( 3959 * acos( cos( radians('%s') ) * cos( radians( LATITUDE ) ) * cos( radians( LONGITUDE ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( LATITUDE ) ) ) ) AS distance FROM Auto_Crime ac left join Method m on ac.METHOD = m.METHOD HAVING distance < '%s' ORDER BY distance",
	mysql_real_escape_string($center_lat),
  	mysql_real_escape_string($center_lng),
  	mysql_real_escape_string($center_lat),
  	mysql_real_escape_string($radius));

$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("NAME", $row['NAME']);
  $newnode->setAttribute("DATE", $row['DATE']);
  $newnode->setAttribute("SHIFT", $row['SHIFT']);
  $newnode->setAttribute("WARD", $row['WARD']);
  $newnode->setAttribute("METHOD", $row['DESCRIPTION']);
  $newnode->setAttribute("LOCATION", $row['LOCATION']);
  $newnode->setAttribute("NARRATIVE", $row['NARRATIVE']);
  $newnode->setAttribute("ICON", "C");
  $newnode->setAttribute("LATITUDE", $row['LATITUDE']);
  $newnode->setAttribute("LONGITUDE", $row['LONGITUDE']);
  $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();
?>
