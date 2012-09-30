<?php /**/ ?><?php
require_once('scripts_configs.php');

$link = mysql_connect(SERVER, USERNAME, PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';
// make foo the current db
$db_selected = mysql_select_db(SCHEMA, $link);
if (!$db_selected) {
    die ('Can\'t use '.SCHEMA.' : ' . mysql_error());
}

	$sxe = simplexml_load_file("http://data.octo.dc.gov/feeds/crime_incidents/crime_incidents_current.xml");
	$sxe->registerXPathNamespace('dcst', 'http://dc.gov/dcstat/types/1.0/');
	$sxe->registerXPathNamespace('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');

	$id = $sxe->xpath('//dcst:nid');
	$date = $sxe->xpath('//dcst:reportdatetime');
	$shift = $sxe->xpath('//dcst:shift');
	$offense = $sxe->xpath('//dcst:offense');
	$method = $sxe->xpath('//dcst:method');
	$block = $sxe->xpath('//dcst:blocksiteaddress');
	$narrative = $sxe->xpath('//dcst:narrative');
	$ward = $sxe->xpath('//dcst:ward');
	$lat = $sxe->xpath('//geo:lat');
	$long = $sxe->xpath('//geo:long');

	for($i=0; $i<count($offense); $i++) {
		if(strpos($offense[$i], "AUTO") !== FALSE) {
			$sql = "SELECT ID FROM Auto_Crime WHERE ID = '".$id[$i]."'";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				echo "<b>UPDATE</b><br />";
				$date_parsed = substr($date[$i], 0, 10);
				$sql = "UPDATE Auto_Crime SET NAME = '".mysql_real_escape_string($offense[$i])."', 
					DATE = '".mysql_real_escape_string($date_parsed)."', 
					SHIFT = '".mysql_real_escape_string($shift[$i])."', 
					WARD = '".mysql_real_escape_string($ward[$i])."', 
					METHOD = '".mysql_real_escape_string($method[$i])."', 
					LOCATION = '".mysql_real_escape_string($block[$i])."', 
					NARRATIVE = '".mysql_real_escape_string($narrative[$i])."', 
					LATITUDE = '".mysql_real_escape_string($lat[$i])."', 
					LONGITUDE = '".mysql_real_escape_string($long[$i])."' 
					WHERE ID = '".$id[$i]."'";
				mysql_query($sql);
			} else {
				echo "<b>INSERT</b><br />";
				echo $id[$i]."<br />";
				echo $date_parsed = substr($date[$i], 0, 10);
				echo $date_parsed;
				echo $shift[$i]."<br />";
				echo $offense[$i]."<br />";
				echo $block[$i]."<br />";
				echo $narrative[$i]."<br />";
				echo $ward[$i]."<br />";
				echo $lat[$i]."<br />";
				echo $long[$i]."<br />";
				$sql = "INSERT INTO Auto_Crime (ID, NAME, DATE, SHIFT, WARD, METHOD, LOCATION, NARRATIVE, LATITUDE, LONGITUDE) VALUES (
							'".mysql_real_escape_string($id[$i])."',
							'".mysql_real_escape_string($offense[$i])."',
							'".mysql_real_escape_string($date_parsed)."',
							'".mysql_real_escape_string($shift[$i])."',
							'".mysql_real_escape_string($ward[$i])."',
							'".mysql_real_escape_string($method[$i])."',
							'".mysql_real_escape_string($block[$i])."',
							'".mysql_real_escape_string($narrative[$i])."',
							'".mysql_real_escape_string($lat[$i])."',
							'".mysql_real_escape_string($long[$i])."'
							)";
				mysql_query($sql);
				echo "<br />";
			}
		}
	}