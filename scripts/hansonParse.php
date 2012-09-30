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

	$sxe = simplexml_load_file("http://data.octo.dc.gov/feeds/src/src_current.xml");
	
	$sxe->registerXPathNamespace('dcst', 'http://dc.gov/dcstat/types/1.0/');
	$sxe->registerXPathNamespace('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');

	
	$id = $sxe->xpath('//dcst:servicerequestid'); //Database record number 
	$servicepriority = $sxe->xpath('//dcst:servicepriority'); //Priority
	$servicecodedescription = $sxe->xpath('//dcst:servicecodedescription'); //Service request type code description  
	$servicetypecodedescription = $sxe->xpath('//dcst:servicetypecodedescription'); //Description of service request type   CHECK THIS FOR PARKING METERS
	$serviceorderdate = $sxe->xpath('//dcst:serviceorderdate');//Service order date 
	$serviceorderstatus = $sxe->xpath('//dcst:serviceorderstatus');//Status of the service 
	$servicecallcount = $sxe->xpath('//dcst:servicecallcount'); //number of calls coming in
	$resolutiondate = $sxe->xpath('//dcst:resolutiondate');//Date the request was resolved 
	$resolution = $sxe->xpath('//dcst:resolution');//resolution
	$serviceduedate = $sxe->xpath('//dcst:serviceduedate'); //Date due to close the service type. Most services have standard closure rates 	
	$servicenotes = $sxe->xpath('//dcst:servicenotes');//service notes
	$siteaddress = $sxe->xpath('//dcst:siteaddress');//location
	$ward = $sxe->xpath('//dcst:ward'); //ward
	$lat = $sxe->xpath('//geo:lat');
	$long = $sxe->xpath('//geo:long');

	
	for($i=0; $i<count($id); $i++) {
		if($servicetypecodedescription[$i] == 'PARKING METERS') {
			$sql = "SELECT ID FROM Hanson WHERE ID = '".mysql_real_escape_string($id[$i])."'";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			
			$colon_position = strpos($siteaddress[$i], ":");
			if($colon_position > 0)
				$meternum = substr($siteaddress[$i],13, ($colon_position-13));
			else 
				$meternum = 'N/A';
			$location = substr($siteaddress[$i],$colon_position+1);
			//echo $colon_position."<br />";
			//echo $siteaddress[$i]."<br />";
			//echo $meternum."<br />";
			//echo $location."<br />";
			if($num_rows == '0') {
				//echo "INSERT<br />";
				$sql = "INSERT INTO Hanson (ID, 
											METERNUM,
											SERVICE_PRIORITY, 
											SERVICE_CODE_DESC, 
											SERVICE_ORDER_DATE, 
											SERVICE_ORDER_STATUS, 
											CALL_COUNT, 
											RESOLUTION_DATE, 
											RESOLUTION, 
											SERVICE_DUE_DATE, 
											SERVICE_NOTES, 
											LOCATION,
											WARD,
											LATITUDE, 
											LONGITUDE) 
						VALUES ( 
						'".mysql_real_escape_string($id[$i])."',
						'".mysql_real_escape_string(trim($meternum))."',
						'".mysql_real_escape_string(trim($servicepriority[$i]))."',
						'".mysql_real_escape_string(trim($servicecodedescription[$i]))."',
						'".mysql_real_escape_string(substr($serviceorderdate[$i],0,10))."',
						'".mysql_real_escape_string(trim($serviceorderstatus[$i]))."',
						'".mysql_real_escape_string(trim($servicecallcount[$i]))."',
						'".mysql_real_escape_string(substr($resolutiondate[$i],0,10))."',
						'".mysql_real_escape_string(trim($resolution[$i]))."',
						'".mysql_real_escape_string(substr($serviceduedate[$i],0,10))."',
						'".mysql_real_escape_string(trim($servicenotes[$i]))."',
						'".mysql_real_escape_string(trim($location))."',
						'".mysql_real_escape_string(trim($ward[$i]))."',
						'".mysql_real_escape_string($lat[$i])."',
						'".mysql_real_escape_string($long[$i])."')";
				mysql_query($sql);
			} else {
				//echo "UPDATE<br />";
				$sql = "UPDATE Hanson SET  
										METERNUM = '".mysql_real_escape_string(trim($meternum))."',
										SERVICE_PRIORITY = '".mysql_real_escape_string(trim($servicepriority[$i]))."',
										SERVICE_CODE_DESC = '".mysql_real_escape_string(trim($servicecodedescription[$i]))."',
										SERVICE_ORDER_DATE	= '".mysql_real_escape_string(substr($serviceorderdate[$i],0,10))."',
										SERVICE_ORDER_STATUS = '".mysql_real_escape_string(trim($serviceorderstatus[$i]))."',
										CALL_COUNT = '".mysql_real_escape_string(trim($servicecallcount[$i]))."',
										RESOLUTION_DATE = '".mysql_real_escape_string(substr($resolutiondate[$i],0,10))."',
										RESOLUTION = '".mysql_real_escape_string(trim($resolution[$i]))."',
										SERVICE_DUE_DATE = '".mysql_real_escape_string(substr($serviceduedate[$i],0,10))."',
										SERVICE_NOTES = '".mysql_real_escape_string(trim($servicenotes[$i]))."',
										LOCATION = '".mysql_real_escape_string(trim($location))."',
										WARD = '".mysql_real_escape_string(trim($ward[$i]))."',
										LATITUDE = '".mysql_real_escape_string($lat[$i])."',
										LONGITUDE = '".mysql_real_escape_string($long[$i])."'
						WHERE ID = '".mysql_real_escape_string($id[$i])."'";
				mysql_query($sql);
			}
			//echo "<hr>";
		}
	}