<?php /**/ ?><?php
/*
 * Open Metro station file with google earth and save as to kml file
 * SELECT METERNUM, ( 3959 * acos( cos( radians(38.877946) ) * cos( radians( `LATITUDE` ) ) * cos( radians( `LONGITUDE` ) - radians(-77.004472) ) + sin( radians(38.877946) ) * sin( radians( `LATITUDE` ) ) ) ) AS distance FROM Parking_Meter HAVING distance < 1.5 ORDER BY distance
 *
 */
$link = mysql_connect('localhost', 'root', 'admin');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
// make foo the current db
$db_selected = mysql_select_db('apps08', $link);
if (!$db_selected) {
    die ('Can\'t use apps08 : ' . mysql_error());
}

if (file_exists('ParkingMeter.kml')) {
	$xml = simplexml_load_file('ParkingMeter.kml');
    
   	foreach($xml->Document->Placemark as $meter) {
   		$sql = "";
   		//echo $meter->name."<br />";
   		$latitude = substr($meter->Point->coordinates,0, strpos($meter->Point->coordinates, ","));
   		//echo $latitude."<br />";
   		$longitude = substr($meter->Point->coordinates, (strlen($latitude)+1),-2);
   		//echo $longitude."<br />";
   		$pieces = explode("<br>", $meter->description);
   		$sql .= "INSERT INTO Parking VALUES (";
   		foreach($pieces as $p) {
   			$key = substr($p, 0, strpos($p,"="));
   			$value = substr($p,strpos($p,"=") + 1);
   			switch($key) {
   				case "METERNUM":
   					//echo "METERNUM-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "BLOCK":
   					//echo "BLOCK-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "STREET":
   					//echo "STREET-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "SIDE":
   					//echo "SIDE-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "HOUR_FROM":
   					//echo "HOUR-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "HOUR_TO":
   					//echo "Hour-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "DAY_FROM":
   					//echo "DF-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "DAY_TO":
   					//echo "DT-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "LIMIT":
   					//echo "LIMIT-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "RATE":
   					//echo "RATE-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "MAINT_ROUT":
   					//echo "MR".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "COLLECTION":
   					//echo "Collection".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "WARD":
   					//echo "WARD-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "STAT":
   					//echo "STAT-". $value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "COMMENTS":
   					//echo "COMMENTS-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   				case "YEAR":
   					//echo "YEAR-".$value." ";
   					$sql .= "'".mysql_real_escape_string($value)."', ";
   					break;
   			}
   		}
   		$sql .= "'".$latitude."', '".$longitude."');";
   		
   		//mysql_query($sql);
    	
    }
} else {
    exit('Failed Check Script.');
}
?>
