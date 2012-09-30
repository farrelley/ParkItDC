<?php /**/ ?><?php 
require_once('xml_configs.php');

function getIconColorTimeOfDay($from, $to) {
	switch(date("m-d-Y")) {
		case "11-11-2008":
			return "G";
			break;
		case "11-26-2008":
			return "G";
			break;
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
$meternum = $_GET["meternumber"];
$meternum2 = $_GET['meternumber'];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("entry");
$parnode = $dom->appendChild($node);


  
$node = $dom->createElement("meter");
$parkingmeter = $parnode->appendChild($node);



  
// Opens a connection to a mySQL server
$connection=mysql_connect (SERVER, USERNAME, PASSWORD );
if (!$connection) {
  die("Not connected : " . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db(SCHEMA, $connection);
if (!$db_selected) {
  die ("Can't use db : " . mysql_error());
}

// Search the rows in the markers table
$query = sprintf("SELECT 
					p.METERNUM,
					p.BLOCK,
					p.STREET,
					p.SIDE,
					p.HOUR_FROM,
					p.HOUR_TO,
					p.DAY_FROM,
					p.DAY_TO,
					p.LIMIT,
					p.RATE,
					p.WARD,
					p.LATITUDE,
					p.LONGITUDE
				FROM 
					Parking p
				WHERE 
					p.METERNUM = '%s'",
  mysql_real_escape_string($meternum));

$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

$row = @mysql_fetch_assoc($result);

if($row['METERNUM'] == '') {
	$meternum = $dom->createElement('METERNUM', 'NOT FOUND');
	$parkingmeter->appendChild($meternum);
} else {
	$meternum = $dom->createElement('METERNUM', $row['METERNUM']);
	$parkingmeter->appendChild($meternum);
}

$block = $dom->createElement('BLOCK', $row['BLOCK']);
$parkingmeter->appendChild($block);

$street = $dom->createElement('STREET', $row['STREET']);
$parkingmeter->appendChild($street);

$side = $dom->createElement('SIDE', $row['SIDE']);
$parkingmeter->appendChild($side);

$hourfrom = $dom->createElement('HOUR_FROM', $row['HOUR_FROM']);
$parkingmeter->appendChild($hourfrom);

$hourto = $dom->createElement('HOUR_TO', $row['HOUR_TO']);
$parkingmeter->appendChild($hourto);

$dayfrom = $dom->createElement('DAY_FROM', $row['DAY_FROM']);
$parkingmeter->appendChild($dayfrom);

$dayto = $dom->createElement('DAY_TO', $row['DAY_TO']);
$parkingmeter->appendChild($dayto);

$limit = $dom->createElement('LIMIT', $row['LIMIT']);
$parkingmeter->appendChild($limit);

$rate = $dom->createElement('RATE', $row['RATE']);
$parkingmeter->appendChild($rate);

$ward = $dom->createElement('WARD', $row['WARD']);
$parkingmeter->appendChild($ward);

$lat = $dom->createElement('LATITUDE', $row['LATITUDE']);
$parkingmeter->appendChild($lat);

$long = $dom->createElement('LONGITUDE', $row['LONGITUDE']);
$parkingmeter->appendChild($long);

$icon_color = getIconColorTimeOfDay($row['HOUR_FROM'], $row['HOUR_TO']);
$icon = $dom->createElement('ICON', $icon_color);
$parkingmeter->appendChild($icon);

 $node = $dom->createElement("issue");
 $problem = $parkingmeter->appendChild($node);
  

// Iterate through the rows, adding XML nodes for eac
// Search the rows in the markers table
$query_hanson = sprintf("SELECT 
					h.ID,
					h.SERVICE_PRIORITY,
					h.SERVICE_CODE_DESC,
					h.SERVICE_ORDER_DATE,
					h.SERVICE_ORDER_STATUS,
					h.CALL_COUNT,
					h.RESOLUTION_DATE,
					h.RESOLUTION,
					h.SERVICE_DUE_DATE,
					h.SERVICE_NOTES
				FROM 
					Hanson h
				WHERE 
					h.METERNUM = '%s'
					and h.SERVICE_ORDER_STATUS = 'OPEN'
				ORDER BY
					h.SERVICE_ORDER_DATE",
  mysql_real_escape_string($meternum2));

$result_hanson = mysql_query($query_hanson);
if (!$result_hanson) {
  die("Invalid query: " . mysql_error());
}
					
while ($row_hanson = mysql_fetch_assoc($result_hanson)){
	$node = $dom->createElement("service");
  	$newnode = $problem->appendChild($node);
	$newnode->setAttribute("ID", $row_hanson['ID']);
  	$newnode->setAttribute("SERVICE_PRIORITY", $row_hanson['SERVICE_PRIORITY']);
  	$newnode->setAttribute("SERVICE_CODE_DESC", $row_hanson['SERVICE_CODE_DESC']);
  	$newnode->setAttribute("SERVICE_ORDER_DATE", $row_hanson['SERVICE_ORDER_DATE']);
  		$newnode->setAttribute("SERVICE_ORDER_STATUS", $row_hanson['SERVICE_ORDER_STATUS']);
  		$newnode->setAttribute("CALL_COUNT", $row_hanson['CALL_COUNT']);
  		$newnode->setAttribute("RESOLUTION_DATE", $row_hanson['RESOLUTION_DATE']);
  		$newnode->setAttribute("RESOLUTION", $row_hanson['RESOLUTION']);
  		$newnode->setAttribute("SERVICE_DUE_DATE", $row_hanson['SERVICE_DUE_DATE']);
  		$newnode->setAttribute("SERVICE_NOTES", $row_hanson['SERVICE_NOTES']);
  	}

echo $dom->saveXML();

?>
