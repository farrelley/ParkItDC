<?php /**/ ?><?php
require_once('scripts_configs.php');
	
	/*for($i=0; $i<3000; $i++) {
		$data = file_get_contents('http://ecolonial.com/location.pl?location='.$i);
		preg_match_all ("/<h3>([^`]*?)<\/h3>/", $data, $matches);

 		//$regex = '/Page 1 of (.+?) results/';
 		//preg_match($regex,$data,$match);
 		//echo var_dump($matches);
 		//echo "<br /><br />";
 		
 		$colonial = explode("</span>",$matches[0][0]);
 	//echo "<pre>";
 	//echo var_dump($colonial);
 	//echo "</pre>";
 	
 	//echo trim(substr(strip_tags($colonial[0]),18))."<br />";
 	 //echo trim(strip_tags($colonial[2]))."<br />";

 		//echo strip_tags($matches[0][0])."<br />";
 		//echo strip_tags($matches[0][1]);
 	if(trim(substr(strip_tags($colonial[0]),18)) != "") {
	 echo "INSERT INTO Garage (COMPANY, GARAGENUM, LOCATION) VALUES (
 			'".mysql_real_escape_string("Colonial Parking, Inc.")."',
 			'".mysql_real_escape_string(trim(substr(strip_tags($colonial[0]),18)))."',
 			'".mysql_real_escape_string(trim(strip_tags($colonial[2]))." ".trim(strip_tags($matches[0][1])))."');";
 		echo "<br />";
 		}
 	}
 	*/
 	
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

$query = "SELECT * FROM Garage WHERE LOCATION like '%Washington%'";

$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}


// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)) {

$num = strpos($row['LOCATION'],"Washington");
//echo $num."<br />";
	$url = "http://local.yahooapis.com/MapsService/V1/geocode?appid=KciphzjV34GPiRbBjUWSu4PbihYPhOZg2uNmHVsk8QggMgJLX8WGLbmqj38E&street=".substr($row['LOCATION'],0,$num)."&city=Washington&state=DC";
	$xml =  simplexml_load_file($url);
	//echo $xml->Result->Latitude
	//echo $xml->Result->Longitude

	echo "UPDATE Garage SET LATITUDE = '".$xml->Result->Latitude."', LONGITUDE = '".$xml->Result->Longitude."' WHERE ID = '".$row['ID']."'";
	echo "<br />";
}
?>
