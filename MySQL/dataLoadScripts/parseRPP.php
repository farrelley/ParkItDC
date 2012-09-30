<?php /**/ ?><?php

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

if (file_exists('rpp.kml')) {
	$xml = simplexml_load_file('rpp.kml');
   	foreach($xml->Document->Folder->Folder->Placemark as $rpp) {
   		$id = $rpp['id'];
   	  	$name = $rpp->name;
   	  	
   	  	$ch = $rpp->children('http://earth.google.com/kml/2.2');
   	
   	  	$pos = strpos(strip_tags($ch->description),"SIDE:");
   	  	$side = substr(strip_tags($ch->description), $pos, 6);
   	  	$sideOfStreet = trim(substr($side,5,1));
   	  	
   	  	$ward_pos = strpos(strip_tags($ch->description),"WARD:");
   	  	$ward = substr(strip_tags($ch->description), $ward_pos, 6);
   	  	$wardNumber = trim(substr($ward,5,1));
   	  	
   	  	//$sql = "";

   		$latitude = substr($rpp->MultiGeometry->Point->coordinates,0, strpos($rpp->MultiGeometry->Point->coordinates, ","));
   		$longitude = substr($rpp->MultiGeometry->Point->coordinates, (strlen($latitude)+1),-2);
   		
   		$line =  trim($rpp->MultiGeometry->MultiGeometry->LineString->coordinates);

   		$sql = "INSERT INTO RPP VALUES ('','".mysql_real_escape_string($name)."', '".mysql_real_escape_string($sideOfStreet)."', '".mysql_real_escape_string($wardNumber)."', '".$longitude."', '".$latitude."', '".$line."');";
   		//mysql_query($sql);
   		
   		echo $sql."<br />";
    }
} else {
    exit('Failed Check Script.');
}
?>
