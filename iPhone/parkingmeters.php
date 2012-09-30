<?php /**/ ?><?php 
 putenv("TZ=US/Eastern");

function getIconColorTimeOfDay($from, $to) {
	switch(date("m-d-Y")) {
		case "12-25-2008":
			return "G";
			break;
		case "01-01-2009":
			return "G";
			break;
		case "01-19-2009":
			return "G";
			break;
		case "02-16-2009":
			return "G";
			break;
		case "05-25-2009":
			return "G";
			break;
		case "07-04-2009":
			return "G";
			break;
		case "09-07-2009":
			return "G";
			break;
		case "10-11-2009":
			return "G";
			break;
		case "11-26-2009":
			return "G";
			break;
		case "12-25-2009":
			return "G";
			break;
		default:
			$today = date('Gi');
			if(($today >= $from && $today <= $to) && date('N') != '7')  {
				if(($to-$today) <= "100") {
					return "Y";
				} else {
					return "R";
				}
			} else {
				return "G";
			}
			break;
	}
}

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = ".2";

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a mySQL server

$connection=mysql_connect ("PIDC_SERVER", "PIDC_USERNAME", "PIDC_PASSWORD");
if (!$connection) {
  die("Not connected : " . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db("PIDC_SCHEMA", $connection);
if (!$db_selected) {
  die ("Can't use db : " . mysql_error());
}

// Search the rows in the markers table
$query = sprintf("SELECT *, ( 3959 * acos( cos( radians('%s') ) * cos( radians( LATITUDE ) ) * cos( radians( LONGITUDE ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( LATITUDE ) ) ) ) AS distance FROM Parking HAVING distance < '%s' ORDER BY distance",
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
  $icon_color = getIconColorTimeOfDay($row['HOUR_FROM'], $row['HOUR_TO']);
  $node = $dom->createElement("marker");
  
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("METERNUM", $row['METERNUM']);
  $newnode->setAttribute("BLOCK", $row['BLOCK']);
  $newnode->setAttribute("SIDE", $row['SIDE']);
  $newnode->setAttribute("HOUR_FROM", $row['HOUR_FROM']);
  $newnode->setAttribute("HOUR_TO", $row['HOUR_TO']); 
  $newnode->setAttribute("DAY_FROM", $row['DAY_FROM']);
  $newnode->setAttribute("DAY_TO", $row['DAY_TO']);
  $newnode->setAttribute("LIMIT", $row['LIMIT']);
  $newnode->setAttribute("RATE", $row['RATE']);
  $newnode->setAttribute("WARD", $row['WARD']);
  $newnode->setAttribute("COMMENTS", $row['COMMENTS']);
  $newnode->setAttribute("STREET", $row['STREET']);
  $newnode->setAttribute("ICON", $icon_color);
  $newnode->setAttribute("LATITUDE", $row['LATITUDE']);
  $newnode->setAttribute("LONGITUDE", $row['LONGITUDE']);
  $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();
?>

